<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test tcdash001 */
    #[Test]
    public function admin_dapat_mengakses_halaman_dashboard()
    {
          /** @var \App\Models\Admin $admin */
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

/** @test tcdash002 */
#[Test]
public function data_dashboard_muncul_sesuai_database()
{
    /** @var \App\Models\Admin $admin */
    $admin = Admin::factory()->create();
    $this->actingAs($admin, 'admin');

    // Buat user untuk wishlist
    $user = \App\Models\User::factory()->create();

    // Produk tersedia (3), tidak tersedia (2)
    Product::factory()->count(3)->create([
        'availability' => 1,
        'category_id' => null
    ]);

    Product::factory()->count(2)->create([
        'availability' => 0,
        'category_id' => null
    ]);

    // Tambah wishlist sesuai user yang valid
    DB::table('wishlist')->insert([
        ['user_id' => $user->id, 'product_id' => 1],
        ['user_id' => $user->id, 'product_id' => 2],
    ]);

    $response = $this->get('/admin/dashboard');

    $response->assertViewHas('totalProduk', 5);
    $response->assertViewHas('produkTersedia', 3);
    $response->assertViewHas('produkTidakTersedia', 2);
    $response->assertViewHas('totalWishlistProduk', 2);
}


    /** @test tcdash003 */
    #[Test]
    public function redirect_ke_login_admin_jika_belum_login()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('admin.login'));
    }

    /** @test tcdash004 */
#[Test]
public function user_tidak_boleh_mengakses_dashboard_admin()
{
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'web');

    $response = $this->get('/admin/dashboard');

    $response->assertRedirect(route('admin.login'));
}

    /** @test tcdash005 */
    #[Test]
    public function produk_tanpa_availability_tidak_mempengaruhi_penghitungan()
    {
        /** @var \App\Models\Admin $admin */
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        Product::factory()->create([
            'availability' => 0, // FIX
            'category_id' => null,
        ]);

        $response = $this->get('/admin/dashboard');

        $response->assertViewHas('produkTersedia', 0);
        $response->assertViewHas('produkTidakTersedia', 1); 
    }


    /** @test tcdash006 */
    #[Test]
    public function wishlist_user_lain_masih_dihitung()
    {
        /** @var \App\Models\Admin $admin */
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $users = \App\Models\User::factory()->count(2)->create();
        $products = Product::factory()->count(2)->create(['category_id' => null]);

        DB::table('wishlist')->insert([
            ['user_id' => $users[0]->id, 'product_id' => $products[0]->id],
            ['user_id' => $users[1]->id, 'product_id' => $products[1]->id],
        ]);

        $response = $this->get('/admin/dashboard');

        $response->assertViewHas('totalWishlistProduk', 2);
    }


}
