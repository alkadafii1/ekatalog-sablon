<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker; 
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 2; $i++) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'main_image' => $faker->imageUrl(640, 480, 'products'),
                'supporting_images' => json_encode([
                    $faker->imageUrl(640, 480, 'products'),
                    $faker->imageUrl(640, 480, 'products'),
                ]),
                'availability' => $faker->boolean,
            ]);
        }
    }
}
