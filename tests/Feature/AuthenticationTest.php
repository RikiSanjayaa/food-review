<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  public function test_registration_page_is_accessible(): void
  {
    $response = $this->get('/register');

    $response->assertOk();
  }

  public function test_user_can_register(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'password123',
      'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('recipes.index'));
    $this->assertDatabaseHas('users', [
      'email' => 'test@example.com',
    ]);
    $this->assertAuthenticated();
  }

  public function test_login_page_is_accessible(): void
  {
    $response = $this->get('/login');

    $response->assertOk();
  }

  public function test_user_can_login(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'password123',
    ]);

    $response->assertRedirect(route('recipes.index'));
    $this->assertAuthenticatedAs($user);
  }

  public function test_user_can_logout(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect(route('recipes.index'));
    $this->assertGuest();
  }

  public function test_guest_is_redirected_to_login_for_protected_routes(): void
  {
    $response = $this->get('/recipes/create');

    $response->assertRedirect('/login');
  }
}
