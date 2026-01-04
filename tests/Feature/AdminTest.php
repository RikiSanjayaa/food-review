<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
  use RefreshDatabase;

  public function test_admin_can_access_tag_index(): void
  {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->get('/admin/tags');

    $response->assertOk();
  }

  public function test_non_admin_cannot_access_tag_index(): void
  {
    $user = User::factory()->create(['is_admin' => false]);

    $response = $this->actingAs($user)->get('/admin/tags');

    $response->assertForbidden();
  }

  public function test_admin_can_create_tag(): void
  {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->post('/admin/tags', [
      'name' => 'New Tag',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('tags', ['name' => 'New Tag']);
  }

  public function test_admin_can_update_tag(): void
  {
    $admin = User::factory()->create(['is_admin' => true]);
    $tag = Tag::factory()->create(['name' => 'Old Tag']);

    $response = $this->actingAs($admin)->put("/admin/tags/{$tag->id}", [
      'name' => 'Updated Tag',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('tags', [
      'id' => $tag->id,
      'name' => 'Updated Tag',
    ]);
  }

  public function test_admin_can_delete_tag(): void
  {
    $admin = User::factory()->create(['is_admin' => true]);
    $tag = Tag::factory()->create();

    $response = $this->actingAs($admin)->delete("/admin/tags/{$tag->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
  }
}
