<?php

namespace Tests\Unit\Model;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FriendshipTest
 *
 * This class contains unit tests for the Friendship model.
 */
class FriendshipTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a friendship can be created with valid data.
     *
     * This test verifies that a friendship can be successfully created and saved in the database
     * with valid data.
     */
    public function test_friendship_can_be_created_with_valid_data(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = Friendship::factory()->create([
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);

        $this->assertDatabaseHas('friendships', [
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);
    }

    /**
     * Test that a friendship belongs to user1 and user2.
     *
     * This test verifies the relationships between the Friendship model and the User model
     * for the two parties in the friendship.
     */
    public function test_friendship_belongs_to_user1_and_user2(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = Friendship::factory()->create([
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);

        $this->assertEquals($user1->id, $friendship->user1->id);
        $this->assertEquals($user2->id, $friendship->user2->id);
    }

    /**
     * Test that a friendship cannot be created without user1.
     *
     * This test verifies that a QueryException is thrown when attempting to create a friendship
     * without associating it with user1.
     */
    public function test_friendship_cannot_be_created_without_user1(): void
    {
        $this->expectException(QueryException::class);

        Friendship::factory()->create(['party1' => null]);
    }

    /**
     * Test that a friendship cannot be created without user2.
     *
     * This test verifies that a QueryException is thrown when attempting to create a friendship
     * without associating it with user2.
     */
    public function test_friendship_cannot_be_created_without_user2(): void
    {
        $this->expectException(QueryException::class);

        Friendship::factory()->create(['party2' => null]);
    }
}
