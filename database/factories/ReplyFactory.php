<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition(): array
    {
        return [
            'review_id' => Review::factory(),
            'user_id' => User::factory(),
            'comment' => $this->faker->sentence,
            'likes_count' => 0,
        ];
    }
}
