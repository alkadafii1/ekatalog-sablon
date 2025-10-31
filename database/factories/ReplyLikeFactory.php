<?php

namespace Database\Factories;

use App\Models\ReplyLike;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyLikeFactory extends Factory
{
    protected $model = ReplyLike::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'review_id' => Review::factory(),
        ];
    }
}
