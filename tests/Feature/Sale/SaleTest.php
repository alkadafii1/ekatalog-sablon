<?php

namespace Tests\Feature\Sale;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function sale001_user_can_create_sale_with_items()
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(2)->create(['availability' => 1]);

        $data = [
            'transaction_date' => now()->format('Y-m-d'),
            'customer_name' => 'John Doe',
            'customer_contact' => '08123456789',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'items' => [
                ['product_id' => $products[0]->id, 'quantity' => 2, 'unit_price' => $products[0]->price],
                ['product_id' => $products[1]->id, 'quantity' => 3, 'unit_price' => $products[1]->price],
            ]
        ];

        $this->actingAs($user)
            ->post(route('sales.store'), $data)
            ->assertRedirect(route('sales.index'))
            ->assertSessionHas('success');

        $sale = Sale::first();
        $expectedTotal = $products[0]->price * 2 + $products[1]->price * 3;
        $this->assertEquals($expectedTotal, $sale->total_amount);
        $this->assertCount(2, $sale->items);
    }

    #[Test]
    public function sale002_user_can_view_sale_index()
    {
        $user = User::factory()->create();
        $sale = Sale::factory()->create(); 
        Sale::factory()->count(5)->create();

        $this->actingAs($user)
            ->get(route('sales.index'))
            ->assertStatus(200)
            ->assertSee($sale->transaction_number);
    }

    #[Test]
    public function sale003_user_can_view_single_sale()
    {
        $user = User::factory()->create();
        $sale = Sale::factory()->create();
        SaleItem::factory()->count(2)->create(['sale_id' => $sale->id]);

        $this->actingAs($user)
            ->get(route('sales.show', $sale->id))
            ->assertStatus(200)
            ->assertSee($sale->transaction_number)
            ->assertSee($sale->items[0]->product_name);
    }

    #[Test]
    public function sale004_user_can_delete_sale()
    {
        $user = User::factory()->create();
        $sale = Sale::factory()->create();
        SaleItem::factory()->count(2)->create(['sale_id' => $sale->id]);

        $this->actingAs($user)
            ->delete(route('sales.destroy', $sale->id))
            ->assertRedirect(route('sales.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('sales', ['id' => $sale->id]);
        $this->assertDatabaseMissing('sale_items', ['sale_id' => $sale->id]);
    }

    #[Test]
    public function sale005_report_returns_filtered_data()
    {
        $user = User::factory()->create();

        $sale1 = Sale::factory()->create([
            'payment_status' => 'paid',
            'transaction_date' => now()->format('Y-m-d')
        ]);
        SaleItem::factory()->create([
            'sale_id' => $sale1->id,
            'quantity' => 2,
            'unit_price' => 100
        ]);

        $sale2 = Sale::factory()->create([
            'payment_status' => 'pending',
            'transaction_date' => now()->subMonth()->format('Y-m-d')
        ]);
        SaleItem::factory()->create([
            'sale_id' => $sale2->id,
            'quantity' => 1,
            'unit_price' => 50
        ]);

        $response = $this->actingAs($user)
                         ->get(route('sales.report', [
                             'start_date' => now()->startOfMonth()->format('Y-m-d'),
                             'end_date' => now()->endOfMonth()->format('Y-m-d'),
                         ]));

        $response->assertStatus(200)
                 ->assertSee($sale1->transaction_number)
                 ->assertDontSee($sale2->transaction_number);
    }

    #[Test]
    public function sale006_cannot_create_sale_without_items()
    {
        $user = User::factory()->create();

        $data = [
            'transaction_date' => now()->format('Y-m-d'),
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'items' => []
        ];

        $this->actingAs($user)
            ->post(route('sales.store'), $data)
            ->assertSessionHasErrors('items');
    }

    #[Test]
    public function sale007_sale_total_amount_calculation()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 1000]);

        $data = [
            'transaction_date' => now()->format('Y-m-d'),
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 3, 'unit_price' => 1200]
            ]
        ];

        $this->actingAs($user)
            ->post(route('sales.store'), $data)
            ->assertRedirect();

        $sale = Sale::first();
        $this->assertEquals(1200 * 3, $sale->total_amount);
    }

    #[Test]
    public function sale008_can_generate_transaction_number()
    {
        $sale1 = Sale::factory()->create();
        $sale2Number = Sale::generateTransactionNumber();

        $this->assertStringStartsWith('INV-', $sale2Number);
        $this->assertNotEquals($sale1->transaction_number, $sale2Number);
    }
}
