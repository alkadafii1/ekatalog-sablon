<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori berdasarkan nama
        $undangan = Category::where('nama', 'Undangan')->first();
        $alatBahan = Category::where('nama', 'alat & bahan')->first();

        // Pastikan kategori ditemukan
        if (!$undangan || !$alatBahan) {
            $this->command->error('Kategori tidak ditemukan. Jalankan CategoriesTableSeeder terlebih dahulu.');
            return;
        }

        // Produk untuk kategori Undangan
        Product::create([
            'name' => 'Undangan Digital A',
            'description' => 'Undangan digital untuk acara pernikahan.',
            'main_image' => 'images/undangan_a.jpg',
            'availability' => true,
            'category_id' => $undangan->id,
        ]);

        // Produk untuk kategori Alat & Bahan
        Product::create([
            'name' => 'Amplop Coklat',
            'description' => 'Amplop untuk undangan berbahan daur ulang.',
            'main_image' => 'images/amplop.jpg',
            'availability' => true,
            'category_id' => $alatBahan->id,
        ]);
    }
}
