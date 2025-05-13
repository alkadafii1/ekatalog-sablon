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
                'nama' => 'Undangan-1010',
                'slug' => 'Undangan',
                'deskripsi' => 'Kategori untuk undangan'
            ],
            [
                'nama' => 'Spidol',
                'slug' => 'Alat & bahan',
                'deskripsi' => 'Kategori untuk alat & bahan'
            ]
        ]);

    }
}