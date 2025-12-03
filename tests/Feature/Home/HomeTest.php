<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper untuk cek isi pesan WhatsApp
     */
    private function assertWhatsappMessageContainsProducts(string $url, $products, $category)
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $message = urldecode($query['text']);

        foreach ($products as $product) {
            $this->assertStringContainsString($product->name, $message);
            $this->assertStringContainsString($category->nama, $message);
            $this->assertStringContainsString($product->description, $message);
            $this->assertStringContainsString(asset('storage/' . $product->main_image), $message);
        }

        $this->assertStringContainsString('Total produk: ' . count($products), $message);
    }

    #[Test]
    public function OD001_redirects_to_whatsapp_with_complete_product_info()
    {
        $category = Category::factory()->create(['nama' => 'Alat & Bahan']);
        $products = Product::factory()->count(2)->create([
            'category_id' => $category->id,
            'name' => 'Produk Test',
            'description' => 'Deskripsi produk test',
            'main_image' => 'images/test.jpg',
        ]);

        $selectedProducts = $products->pluck('id')->toArray();

        $response = $this->post('/order/from-wishlist', [
            'selected_products' => $selectedProducts
        ]);

        $response->assertStatus(302);
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('https://wa.me/', $redirectUrl);

        $this->assertWhatsappMessageContainsProducts($redirectUrl, $products, $category);
    }

    #[Test]
    public function OD002_fails_validation_if_no_products_selected()
    {
        $response = $this->post('/order/from-wishlist', [
            'selected_products' => []
        ]);

        $response->assertSessionHasErrors('selected_products');
    }

    #[Test]
    public function OD003_fails_validation_if_product_does_not_exist()
    {
        $response = $this->post('/order/from-wishlist', [
            'selected_products' => [9999]
        ]);

        $response->assertSessionHasErrors('selected_products.0');
    }

    #[Test]
    public function OD004_fails_validation_if_mixed_valid_and_invalid_products()
    {
        $category = Category::factory()->create(['nama' => 'Alat & Bahan']);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Produk Test',
            'description' => 'Deskripsi produk test',
            'main_image' => 'images/test.jpg',
        ]);

        $selectedProducts = [$product->id, 9999]; // 1 valid, 1 invalid

        $response = $this->post('/order/from-wishlist', [
            'selected_products' => $selectedProducts
        ]);

        $response->assertSessionHasErrors('selected_products.1');
    }
}
