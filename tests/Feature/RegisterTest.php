<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

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
