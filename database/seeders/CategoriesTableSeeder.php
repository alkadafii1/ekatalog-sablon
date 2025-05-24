<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'nama' => 'Undangan',
                'deskripsi' => 'Kategori untuk undangan',
            ],
            [
                'nama' => 'alat & bahan',
                'deskripsi' => 'Kategori untuk alat & bahan',
            ]
        ]);

    }
}