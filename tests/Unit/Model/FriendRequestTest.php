<?php

namespace Tests\Unit\Model;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FriendRequestTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_friend_request_cannot_be_created_without_sender(): void
    {
        $this->expectException(QueryException::class);

        FriendRequest::factory()->create(['sender_id' => null]);
    }

    public function test_friend_request_cannot_be_created_without_receiver(): void
    {
        $this->expectException(QueryException::class);

        FriendRequest::factory()->create(['receiver_id' => null]);
    }
}
