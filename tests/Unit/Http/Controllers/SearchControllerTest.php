<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_searched_correctly(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Doe']);
        $user3 = User::factory()->create(['name' => 'John Smith']);

        $response = $this->getJson('/api/socials/search?query=John');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_friends_are_retrieved_correctly(): void
    {

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user2->id]);
        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user3->id]);

        Auth::login($user1);

        $response = $this->getJson('/api/socials/friends');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_online_friends_are_retrieved_correctly(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create(['is_online' => true]);
        $user3 = User::factory()->create(['is_online' => true]);

        //create friendships
        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user2->id]);
        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user3->id]);

        Auth::login($user1);

        $response = $this->getJson('/api/socials/online-friends');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_friend_requests_are_retrieved_correctly(): void
    {

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        FriendRequest::factory()->create(['sender_id' => $user2->id, 'receiver_id' => $user1->id]);
        FriendRequest::factory()->create(['sender_id' => $user3->id, 'receiver_id' => $user1->id]);

        Auth::login($user1);

        $response = $this->getJson('/api/socials/friend-requests');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_user_is_not_retrieved(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->getJson('/api/socials/search?query=' . $user->username);

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function test_user_not_found_returns_error(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->getJson('/api/socials/search?query=9999');

        $response->assertJsonCount(0);
    }
}
