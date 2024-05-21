<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FriendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_friend_request_can_be_accepted(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $friendRequest = FriendRequest::factory()->create([
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
        ]);

        Auth::login($user1);
        $response = $this->postJson('/api/socials/accept-friend-request', ['friendId' => $user2->id]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('friendships', [
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);
        $this->assertDatabaseMissing('friend_requests', [
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
        ]);
    }

    public function test_friend_request_can_be_rejected(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $friendRequest = FriendRequest::factory()->create([
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
        ]);

        Auth::login($user1);
        $response = $this->postJson('/api/socials/reject-friend-request', ['friendId' => $user2->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('friend_requests', [
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
        ]);
    }

    public function test_friend_request_can_be_sent(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Auth::login($user1);
        $response = $this->postJson('/api/socials/send-friend-request', ['friendId' => $user2->id]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('friend_requests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
        ]);
    }

    public function test_friend_can_be_removed(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $friendship = Friendship::factory()->create([
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);

        Auth::login($user1);
        $response = $this->postJson('/api/socials/remove-friend', ['friendId' => $user2->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('friendships', [
            'party1' => $user1->id,
            'party2' => $user2->id,
        ]);
    }
}
