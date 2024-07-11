<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Class SearchControllerTest
 *
 * This class contains unit tests for the SearchController.
 */
class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that users are searched correctly.
     *
     * This test verifies that users can be searched by their name.
     */
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

    /**
     * Test that friends are retrieved correctly.
     *
     * This test verifies that a user's friends can be retrieved.
     */
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

    /**
     * Test that online friends are retrieved correctly.
     *
     * This test verifies that a user's online friends can be retrieved.
     */
    public function test_online_friends_are_retrieved_correctly(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create(['is_online' => true]);
        $user3 = User::factory()->create(['is_online' => true]);

        // Create friendships
        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user2->id]);
        Friendship::factory()->create(['party1' => $user1->id, 'party2' => $user3->id]);

        Auth::login($user1);

        $response = $this->getJson('/api/socials/online-friends');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /**
     * Test that friend requests are retrieved correctly.
     *
     * This test verifies that a user can retrieve their friend requests.
     */
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

    /**
     * Test that a user is not retrieved in the search results.
     *
     * This test verifies that a user cannot search for themselves.
     */
    public function test_user_is_not_retrieved(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->getJson('/api/socials/search?query='.$user->username);

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    /**
     * Test that user not found returns an error.
     *
     * This test verifies that searching for a non-existent user returns no results.
     */
    public function test_user_not_found_returns_error(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->getJson('/api/socials/search?query=9999');

        $response->assertJsonCount(0);
    }
}
