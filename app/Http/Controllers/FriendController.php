<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FriendController
 *
 * The FriendController handles actions related to friend management in the application.
 * This includes accepting and rejecting friend requests, sending friend requests, and removing friends.
 */
class FriendController extends Controller
{
    /**
     * Accept a friend request.
     *
     * This method accepts a friend request from another user.
     * It creates a new Friendship record and deletes the corresponding FriendRequest record.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse
     */
    public function acceptFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (! $friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendship = new Friendship();
        $friendship->party1 = $currentUserId;
        $friendship->party2 = $friendId;
        $friendship->save();

        $friendRequest = FriendRequest::where('sender_id', $friendId)->where('receiver_id', $currentUserId)->first();
        $friendRequest->delete();

        return response()->json(['message' => 'Friend request accepted']);
    }

    /**
     * Reject a friend request.
     *
     * This method rejects a friend request from another user.
     * It deletes the corresponding FriendRequest record.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse
     */
    public function rejectFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (! $friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendRequest = FriendRequest::where('sender_id', $friendId)->where('receiver_id', $currentUserId)->first();
        $friendRequest->delete();

        return response()->json(['message' => 'Friend request rejected']);
    }

    /**
     * Send a friend request.
     *
     * This method sends a friend request to another user.
     * It creates a new FriendRequest record.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse
     */
    public function sendFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (! $friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendRequest = new FriendRequest();
        $friendRequest->sender_id = $currentUserId;
        $friendRequest->receiver_id = $friendId;
        $friendRequest->save();

        return response()->json(['message' => 'Friend request sent']);
    }

    /**
     * Remove a friend.
     *
     * This method removes a friend from the authenticated user's friend list.
     * It deletes the corresponding Friendship record.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse
     */
    public function removeFriend(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (! $friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendship = Friendship::where(function ($q) use ($currentUserId, $friendId) {
            $q->where('party1', $currentUserId)->where('party2', $friendId);
        })->orWhere(function ($q) use ($currentUserId, $friendId) {
            $q->where('party1', $friendId)->where('party2', $currentUserId);
        })->first();

        $friendship->delete();

        return response()->json(['message' => 'Friend removed']);
    }
}
