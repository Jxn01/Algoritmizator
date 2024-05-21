<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function test_unsuccessful_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('i-love-laravel'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $this->assertGuest();
    }

    public function test_successful_registration_with_valid_data(): void
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'testuser@example.com',
        ]);
    }

    public function test_unsuccessful_registration_with_invalid_data(): void
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'not-an-email',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
    }

    public function test_successful_password_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $token = Password::createToken($user);

        $response = $this->postJson('/api/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_unsuccessful_password_reset_with_invalid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->postJson('/api/reset-password', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }
}
