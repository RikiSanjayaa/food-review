<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_lists_recipes(): void
    {
        $recipe = Recipe::factory()->create(['title' => 'Test Pasta']);

        $response = $this->get('/');

        $response->assertOk()->assertSee('Test Pasta');
    }

    public function test_user_can_post_review(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->post(route('reviews.store', $recipe), [
            'rating' => 5,
            'comment' => 'Great!',
        ]);

        $response->assertRedirect(route('recipes.show', $recipe));
        $this->assertDatabaseHas('reviews', [
            'recipe_id' => $recipe->id,
            'user_id' => $user->id,
            'rating' => 5,
        ]);
    }
}

