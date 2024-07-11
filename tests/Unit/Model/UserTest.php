<?php

namespace Tests\Unit\Model;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * This class contains unit tests for the User model.
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can be created with valid data.
     *
     * This test verifies that a user can be successfully created and saved in the database
     * with valid data.
     */
    public function test_user_can_be_created_with_valid_data(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }

    /**
     * Test that the user's level is correctly calculated.
     *
     * This test verifies that the user's level is calculated correctly based on their total XP.
     */
    public function test_user_level_is_correctly_calculated(): void
    {
        $user = User::factory()->create(['total_xp' => 150]);

        $this->assertEquals(2, $user->level);
    }

    /**
     * Test that a user can send a friend request.
     *
     * This test verifies that a user can send a friend request to another user.
     */
    public function test_user_can_send_friend_request(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->senders()->create(['receiver_id' => $user2->id]);

        $this->assertCount(1, $user1->senders);
        $this->assertCount(1, $user2->receivers);
    }

    /**
     * Test that a user can receive a friend request.
     *
     * This test verifies that a user can receive a friend request from another user.
     */
    public function test_user_can_receive_friend_request(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user2->receivers()->create(['sender_id' => $user1->id]);

        $this->assertCount(1, $user1->senders);
        $this->assertCount(1, $user2->receivers);
    }

    /**
     * Test that a user can have successful attempts.
     *
     * This test verifies that a user can have successful attempts recorded in the database.
     */
    public function test_user_can_have_successful_attempts(): void
    {
        $user = User::factory()->create();
        $user->successfulAttempts()->create(['attempt_id' => 1, 'assignment_id' => 1]);

        $this->assertCount(1, $user->successfulAttempts);
    }

    /**
     * Test that a user can have attempts.
     *
     * This test verifies that a user can have attempts recorded in the database.
     */
    public function test_user_can_have_attempts(): void
    {
        $user = User::factory()->create();
        $user->attempts()->create(['assignment_id' => 1, 'total_score' => 10, 'max_score' => 10, 'time' => 10, 'passed' => true]);

        $this->assertCount(1, $user->attempts);
    }
}
