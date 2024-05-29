<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Class LoginTest
 *
 * This class contains feature tests for the login functionality.
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can login with correct credentials.
     *
     * This test creates a user with a known password, attempts to login with that
     * password, and asserts that the user is authenticated.
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that a user cannot login with an incorrect password.
     *
     * This test creates a user with a known password, attempts to login with an
     * incorrect password, and asserts that the user is not authenticated.
     */
    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('i-love-laravel'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(401);
        $this->assertGuest();
    }
}
