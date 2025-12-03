<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * PD001 - Index menampilkan semua produk
     */
    #[Test]
    public function PD001_index_displays_products()
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        foreach ($products as $product) {
            $response->assertSeeText($product->name);
        }
    }

    /**
     * PD002 - Pencarian produk (match & tidak match)
     */
    #[Test]
    public function PD002_index_search_filters_products()
    {
        $category = Category::factory()->create();
        $match = Product::factory()->create(['name' => 'Laptop Test', 'category_id' => $category->id]);
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->get('/products?search=Laptop');
        $response->assertStatus(200);
        $response->assertSeeText('Laptop Test');
        $this->assertStringNotContainsString(
            Product::where('name', '!=', 'Laptop Test')->first()->name,
            $response->getContent()
        );

        // Search produk tidak ada
        $response2 = $this->get('/products?search=NonExist');
        $response2->assertStatus(200);
        $response2->assertDontSeeText('Laptop Test');
    }

    /**
     * PD003 - Store produk baru (valid & invalid)
     */
    #[Test]
    public function PD003_store_creates_product()
    {
        Storage::fake('public');
        $category = Category::factory()->create();

        $file = UploadedFile::fake()->image('product.jpg');

        // Valid input
        $response = $this->post('/products', [
            'name' => 'Produk Baru',
            'description' => 'Deskripsi Produk',
            'main_image' => $file,
            'availability' => 1,
            'category_id' => $category->id,
            'price' => 10000,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Produk Baru']);
        Storage::disk('public')->assertExists('product_images/' . $file->hashName());

        // Invalid input (missing name)
        $response2 = $this->post('/products', [
            'description' => 'Deskripsi',
            'main_image' => $file,
            'availability' => 1,
            'category_id' => $category->id,
            'price' => 10000,
        ]);
        $response2->assertSessionHasErrors('name');
    }

    /**
     * PD004 - Update produk (ubah semua field + gambar)
     */
    #[Test]
    public function PD004_update_product()
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'main_image' => 'product_images/old.jpg'
        ]);

        Storage::disk('public')->put('product_images/old.jpg', 'dummy');

        $newFile = UploadedFile::fake()->image('new.jpg');

        $response = $this->put("/products/{$product->id}", [
            'name' => 'Produk Updated',
            'description' => 'Deskripsi Updated',
            'main_image' => $newFile,
            'availability' => 0,
            'category_id' => $category->id,
            'price' => 5000,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Produk Updated']);
        Storage::disk('public')->assertExists('product_images/' . $newFile->hashName());
        Storage::disk('public')->assertMissing('product_images/old.jpg');
    }

    /**
     * PD005 - Update produk gagal validasi
     */
    #[Test]
    public function PD005_update_product_validation_fails()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->put("/products/{$product->id}", [
            'name' => '', // invalid
            'description' => 'Deskripsi',
            'availability' => 1,
            'category_id' => $category->id,
            'price' => 10000,
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * PD006 - Show produk detail
     */
    #[Test]
    public function PD006_show_displays_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get("/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertSeeText($product->name);
        $response->assertSeeText($product->description);
    }

    /**
     * PD007 - Destroy produk beserta gambar
     */
    #[Test]
    public function PD007_destroy_deletes_product_and_image()
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'main_image' => 'product_images/test.jpg'
        ]);
        Storage::disk('public')->put('product_images/test.jpg', 'dummy');

        $response = $this->delete("/products/{$product->id}");

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing('product_images/test.jpg');
    }

    /**
     * PD008 - Filter by category
     */
    #[Test]
    public function PD008_by_category_filters_products()
    {
        $cat1 = Category::factory()->create(['nama' => 'Alat']);
        $cat2 = Category::factory()->create(['nama' => 'Bahan']);

        $p1 = Product::factory()->create(['name' => 'Produk1', 'category_id' => $cat1->id]);
        $p2 = Product::factory()->create(['name' => 'Produk2', 'category_id' => $cat2->id]);

        $response = $this->get('/products/kategori/Alat');

        $response->assertStatus(200);
        $response->assertSeeText('Produk1');
        $response->assertDontSeeText('Produk2');
    }

    /**
     * PD009 - Filter kategori tidak ada
     */
    #[Test]
    public function PD009_by_category_no_results()
    {
        $cat1 = Category::factory()->create(['nama' => 'Alat']);
        Product::factory()->create(['name' => 'Produk1', 'category_id' => $cat1->id]);

        $response = $this->get('/products/kategori/NonExist');

        $response->assertStatus(200);
        $response->assertDontSeeText('Produk1');
    }

    /**
     * PD010 - Store produk gagal karena file bukan gambar
     */
    #[Test]
    public function PD010_store_invalid_image_fails()
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $file = UploadedFile::fake()->create('notimage.txt', 100);

        $response = $this->post('/products', [
            'name' => 'Produk Gagal',
            'description' => 'Deskripsi',
            'main_image' => $file,
            'availability' => 1,
            'category_id' => $category->id,
            'price' => 10000,
        ]);

        $response->assertSessionHasErrors('main_image');
    }
}
