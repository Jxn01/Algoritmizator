<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RegisterTest
 *
 * This class contains feature tests for the registration functionality.
 */
class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can register with valid data.
     *
     * This test attempts to register a user with valid data and asserts that the
     * registration is successful and the user is saved in the database.
     */
    public function test_user_can_register_with_valid_data(): void
    {
        $userData = [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /**
     * Test that a user cannot register with invalid data.
     *
     * This test attempts to register a user with invalid data (e.g., invalid email)
     * and asserts that the registration fails and the user is not saved in the database.
     */
    public function test_user_cannot_register_with_invalid_data(): void
    {
        $userData = [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'not-an-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'not-an-email',
        ]);
    }
}
