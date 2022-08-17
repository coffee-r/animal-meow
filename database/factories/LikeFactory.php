<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $post = Post::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'like_count' => mt_rand(0, 99999999999999),
        ];
    }
}
