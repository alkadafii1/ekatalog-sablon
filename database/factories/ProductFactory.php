<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'main_image' => 'default.jpg',
            'availability' => $this->faker->randomElement([0, 1]),
            'category_id' => Category::factory(),
            'price' => $this->faker->numberBetween(5000, 50000),
        ];
    }
}
