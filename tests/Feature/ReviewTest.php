<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
  use RefreshDatabase;

  public function test_authenticated_user_can_post_review(): void
  {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $response = $this->actingAs($user)->post(route('reviews.store', $recipe), [
      'rating' => 5,
      'comment' => 'Delicious recipe!',
    ]);

    $response->assertRedirect(route('recipes.show', $recipe));
    $this->assertDatabaseHas('reviews', [
      'recipe_id' => $recipe->id,
      'user_id' => $user->id,
      'rating' => 5,
      'comment' => 'Delicious recipe!',
    ]);
  }

  public function test_guest_cannot_post_review(): void
  {
    $recipe = Recipe::factory()->create();

    $response = $this->post(route('reviews.store', $recipe), [
      'rating' => 5,
      'comment' => 'Great!',
    ]);

    $response->assertRedirect('/login');
  }

  public function test_user_can_update_own_review(): void
  {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $recipe->reviews()->create([
      'user_id' => $user->id,
      'rating' => 3,
      'comment' => 'Original comment',
    ]);

    // Posting again should update the existing review
    $response = $this->actingAs($user)->post(route('reviews.store', $recipe), [
      'rating' => 5,
      'comment' => 'Updated comment',
    ]);

    $response->assertRedirect(route('recipes.show', $recipe));
    $this->assertDatabaseHas('reviews', [
      'recipe_id' => $recipe->id,
      'user_id' => $user->id,
      'rating' => 5,
      'comment' => 'Updated comment',
    ]);
    $this->assertDatabaseCount('reviews', 1);
  }

  public function test_owner_can_delete_review(): void
  {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)
      ->delete(route('reviews.destroy', [$recipe, $review]));

    $response->assertRedirect(route('recipes.show', $recipe));
    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
  }

  public function test_non_owner_cannot_delete_review(): void
  {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'user_id' => $owner->id,
    ]);

    $response = $this->actingAs($other)
      ->delete(route('reviews.destroy', [$recipe, $review]));

    $response->assertForbidden();
    $this->assertDatabaseHas('reviews', ['id' => $review->id]);
  }

  public function test_admin_can_delete_any_review(): void
  {
    $owner = User::factory()->create();
    $admin = User::factory()->create(['is_admin' => true]);
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'user_id' => $owner->id,
    ]);

    $response = $this->actingAs($admin)
      ->delete(route('reviews.destroy', [$recipe, $review]));

    $response->assertRedirect(route('recipes.show', $recipe));
    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
  }

  public function test_user_can_report_review(): void
  {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'is_reported' => false,
    ]);

    $response = $this->actingAs($user)
      ->post(route('reviews.report', $review));

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
      'id' => $review->id,
      'is_reported' => true,
    ]);
  }

  public function test_admin_can_moderate_review(): void
  {
    $admin = User::factory()->create(['is_admin' => true]);
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'is_hidden' => false,
    ]);

    $response = $this->actingAs($admin)
      ->patch(route('reviews.moderate', $review));

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
      'id' => $review->id,
      'is_hidden' => true,
    ]);
  }

  public function test_non_admin_cannot_moderate_review(): void
  {
    $user = User::factory()->create(['is_admin' => false]);
    $recipe = Recipe::factory()->create();
    $review = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'is_hidden' => false,
    ]);

    $response = $this->actingAs($user)
      ->patch(route('reviews.moderate', $review));

    $response->assertForbidden();
  }

  public function test_user_can_reply_to_review(): void
  {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $parentReview = Review::factory()->create([
      'recipe_id' => $recipe->id,
      'parent_id' => null,
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $recipe), [
      'rating' => 5,
      'comment' => 'This is a reply',
      'parent_id' => $parentReview->id,
    ]);

    $response->assertRedirect(route('recipes.show', $recipe));
    $this->assertDatabaseHas('reviews', [
      'recipe_id' => $recipe->id,
      'user_id' => $user->id,
      'rating' => 5,
      'parent_id' => $parentReview->id,
      'comment' => 'This is a reply',
    ]);
  }

  public function test_review_recalculates_recipe_rating(): void
  {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $recipe = Recipe::factory()->create([
      'rating_avg' => 0,
      'rating_count' => 0,
    ]);

    $this->actingAs($user1)->post(route('reviews.store', $recipe), [
      'rating' => 4,
      'comment' => 'Good',
    ]);

    $recipe->refresh();
    $this->assertEquals(4.0, $recipe->rating_avg);
    $this->assertEquals(1, $recipe->rating_count);

    $this->actingAs($user2)->post(route('reviews.store', $recipe), [
      'rating' => 5,
      'comment' => 'Excellent',
    ]);

    $recipe->refresh();
    $this->assertEquals(4.5, $recipe->rating_avg);
    $this->assertEquals(2, $recipe->rating_count);
  }
}
