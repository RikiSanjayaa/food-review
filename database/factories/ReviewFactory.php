<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->sentence(15),
            'is_hidden' => false,
            'is_reported' => false,
        ];
    }
}

