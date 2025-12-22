<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title.'-'.$this->faker->unique()->randomNumber()),
            'description' => $this->faker->sentence(12),
            'ingredients' => collect($this->faker->words(8))
                ->map(fn ($item) => '• '.$item)
                ->implode("\n"),
            'steps' => collect(range(1, 4))
                ->map(fn ($i) => $i.'. '.$this->faker->sentence(10))
                ->implode("\n"),
            'prep_time' => $this->faker->numberBetween(5, 20),
            'cook_time' => $this->faker->numberBetween(10, 40),
            'servings' => $this->faker->numberBetween(2, 6),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'diet' => $this->faker->randomElement(['', 'vegan', 'vegetarian', 'gluten-free']),
            'cuisine' => $this->faker->randomElement(['Italian', 'Thai', 'Mexican', 'American']),
            'hero_image' => null,
            'rating_avg' => 0,
            'rating_count' => 0,
            'published_at' => now(),
        ];
    }
}

