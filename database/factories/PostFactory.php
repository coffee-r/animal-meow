<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\AnimalType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $animalType = AnimalType::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'animal_type_id' => $animalType->id,
            'message' => fake()->text(),
            'like_total_count' => mt_rand(0, 99999999999999),
        ];
    }
}
