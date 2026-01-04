<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_can_view_own_profile(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk()
      ->assertSee($user->name);
  }

  public function test_user_can_view_other_user_profile(): void
  {
    $user = User::factory()->create();
    $other = User::factory()->create(['name' => 'Other User']);

    $response = $this->actingAs($user)->get(route('users.show', $other));

    $response->assertOk()
      ->assertSee('Other User');
  }

  public function test_viewing_own_profile_via_users_route_redirects(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('users.show', $user));

    $response->assertRedirect(route('profile.index'));
  }

  public function test_guest_cannot_view_profile_page(): void
  {
    $response = $this->get('/profile');

    $response->assertRedirect('/login');
  }

  public function test_user_can_access_edit_profile_page(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile/edit');

    $response->assertOk();
  }

  public function test_user_can_update_profile(): void
  {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put('/profile', [
      'name' => 'Updated Name',
      'email' => $user->email,
      'bio' => 'Updated bio',
    ]);

    $response->assertRedirect(route('profile.index'));
    $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => 'Updated Name',
      'bio' => 'Updated bio',
    ]);
  }

  public function test_user_can_update_password(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('oldpassword'),
    ]);

    $response = $this->actingAs($user)->put('/password', [
      'current_password' => 'oldpassword',
      'password' => 'newpassword123',
      'password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect(route('profile.index'));

    // Verify can login with new password
    $this->post('/logout');
    $this->post('/login', [
      'email' => $user->email,
      'password' => 'newpassword123',
    ]);
    $this->assertAuthenticatedAs($user->fresh());
  }
}
