<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = Recipe::all();
        $users = User::all();

        if ($recipes->isEmpty() || $users->isEmpty()) {
            return;
        }

        Review::factory(30)->make()->each(function ($review) use ($recipes, $users): void {
            $review->recipe_id = $recipes->random()->id;
            $review->user_id = $users->random()->id;
            $review->save();
        });

        // Ensure each recipe has at least one review
        foreach ($recipes as $recipe) {
            if (! $recipe->reviews()->exists()) {
                $recipe->reviews()->create([
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5),
                    'comment' => 'Tasty and easy to follow.',
                ]);
            }

            $recipe->recalculateRatings();
        }
    }
}

