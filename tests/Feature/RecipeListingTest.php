<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_recipe_index_page_is_accessible(): void
    {
        $response = $this->get('/recipes');

        $response->assertOk();
    }

    public function test_recipe_index_can_filter_by_search(): void
    {
        Recipe::factory()->create(['title' => 'Nasi Goreng']);
        Recipe::factory()->create(['title' => 'Sate Ayam']);

        $response = $this->get('/recipes?q=nasi');

        $response->assertOk()
            ->assertSee('Nasi Goreng')
            ->assertDontSee('Sate Ayam');
    }

    public function test_recipe_index_can_filter_by_tags(): void
    {
        $tag = Tag::factory()->create(['name' => 'Pedas']);
        $recipe1 = Recipe::factory()->create(['title' => 'Sambal']);
        $recipe2 = Recipe::factory()->create(['title' => 'Sayur']);
        $recipe1->tags()->attach($tag);

        $response = $this->get('/recipes?tags[]=' . $tag->id);

        $response->assertOk()
            ->assertSee('Sambal')
            ->assertDontSee('Sayur');
    }

    public function test_recipe_index_can_sort_by_rating(): void
    {
        Recipe::factory()->create(['title' => 'Low Rated', 'rating_avg' => 2.0]);
        Recipe::factory()->create(['title' => 'High Rated', 'rating_avg' => 5.0]);

        $response = $this->get('/recipes?sort=rating');

        $response->assertOk();
        // High rated should appear before low rated
        $this->assertTrue(
            strpos($response->getContent(), 'High Rated') < strpos($response->getContent(), 'Low Rated')
        );
    }

    public function test_recipe_show_displays_recipe_details(): void
    {
        $recipe = Recipe::factory()->create([
            'title' => 'Rendang',
            'description' => 'Delicious beef rendang',
        ]);

        $response = $this->get(route('recipes.show', $recipe));

        $response->assertOk()
            ->assertSee('Rendang')
            ->assertSee('Delicious beef rendang');
    }

    public function test_authenticated_user_can_access_create_recipe_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/recipes/create');

        $response->assertOk();
    }

    public function test_authenticated_user_can_create_recipe(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/recipes', [
            'title' => 'New Recipe',
            'description' => 'A test recipe',
            'ingredients' => 'Salt, pepper',
            'steps' => '1. Mix ingredients',
            'difficulty' => 'mudah',
        ]);

        $this->assertDatabaseHas('recipes', [
            'title' => 'New Recipe',
            'user_id' => $user->id,
        ]);
        $response->assertRedirect();
    }

    public function test_guest_cannot_create_recipe(): void
    {
        $response = $this->post('/recipes', [
            'title' => 'New Recipe',
            'description' => 'Test',
            'ingredients' => 'Salt',
            'steps' => 'Cook',
            'difficulty' => 'mudah',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_owner_can_edit_recipe(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('recipes.edit', $recipe));

        $response->assertOk();
    }

    public function test_non_owner_cannot_edit_recipe(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->get(route('recipes.edit', $recipe));

        $response->assertForbidden();
    }

    public function test_admin_can_edit_any_recipe(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($admin)->get(route('recipes.edit', $recipe));

        $response->assertOk();
    }

    public function test_owner_can_update_recipe(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('recipes.update', $recipe), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'ingredients' => 'Updated ingredients',
            'steps' => 'Updated steps',
            'difficulty' => 'sedang',
        ]);

        $response->assertRedirect(route('recipes.show', $recipe));
        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_owner_can_delete_recipe(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('recipes.destroy', $recipe));

        $response->assertRedirect(route('recipes.index'));
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    public function test_non_owner_cannot_delete_recipe(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->delete(route('recipes.destroy', $recipe));

        $response->assertForbidden();
        $this->assertDatabaseHas('recipes', ['id' => $recipe->id]);
    }

    public function test_admin_can_delete_any_recipe(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($admin)->delete(route('recipes.destroy', $recipe));

        $response->assertRedirect(route('recipes.index'));
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }
}
