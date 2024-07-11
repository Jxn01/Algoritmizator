<?php

namespace Tests\Unit\Model;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FriendRequestTest
 *
 * This class contains unit tests for the FriendRequest model.
 */
class FriendRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a friend request can be created with valid data.
     *
     * This test verifies that a friend request can be successfully created and saved in the database
     * with valid data.
     */
    public function test_friend_request_can_be_created_with_valid_data(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $friendRequest = FriendRequest::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->assertDatabaseHas('friend_requests', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);
    }

    /**
     * Test that a friend request belongs to a sender and a receiver.
     *
     * This test verifies the relationships between the FriendRequest model, the User model (as sender),
     * and the User model (as receiver).
     */
    public function test_friend_request_belongs_to_sender_and_receiver(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $friendRequest = FriendRequest::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->assertEquals($sender->id, $friendRequest->sender->id);
        $this->assertEquals($receiver->id, $friendRequest->receiver->id);
    }

    /**
     * Test that a friend request cannot be created without a sender.
     *
     * This test verifies that a QueryException is thrown when attempting to create a friend request
     * without associating it with a sender.
     */
    public function test_friend_request_cannot_be_created_without_sender(): void
    {
        $this->expectException(QueryException::class);

        FriendRequest::factory()->create(['sender_id' => null]);
    }

    /**
     * Test that a friend request cannot be created without a receiver.
     *
     * This test verifies that a QueryException is thrown when attempting to create a friend request
     * without associating it with a receiver.
     */
    public function test_friend_request_cannot_be_created_without_receiver(): void
    {
        $this->expectException(QueryException::class);

        FriendRequest::factory()->create(['receiver_id' => null]);
    }
}
