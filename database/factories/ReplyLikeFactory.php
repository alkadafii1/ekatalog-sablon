<?php

namespace Database\Factories;

use App\Models\ReplyLike;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyLikeFactory extends Factory
{
    protected $model = ReplyLike::class;

    public function definition()
    {
        return [
            'reply_id' => Reply::factory(),
            'user_id' => User::factory(),
        ];
    }
}
