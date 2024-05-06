<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function acceptFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (!$friend) {
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

    public function rejectFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (!$friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendRequest = FriendRequest::where('sender_id', $friendId)->where('receiver_id', $currentUserId)->first();
        $friendRequest->delete();

        return response()->json(['message' => 'Friend request rejected']);
    }

    public function sendFriendRequest(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (!$friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendRequest = new FriendRequest();
        $friendRequest->sender_id = $currentUserId;
        $friendRequest->receiver_id = $friendId;
        $friendRequest->save();

        return response()->json(['message' => 'Friend request sent']);
    }

    public function removeFriend(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);
        if (!$friend) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $friendship = Friendship::where(function($q) use ($currentUserId, $friendId) {
            $q->where('party1', $currentUserId)->where('party2', $friendId);
        })->orWhere(function($q) use ($currentUserId, $friendId) {
            $q->where('party1', $friendId)->where('party2', $currentUserId);
        })->first();

        $friendship->delete();

        return response()->json(['message' => 'Friend removed']);
    }
}
