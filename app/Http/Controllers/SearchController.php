<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public static function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json([]);
        }

        $currentUserId = Auth::getUser()->id;
        $results = User::where('id', '!=', $currentUserId)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('username', 'LIKE', '%' . $query . '%');
            })
            ->get();

        $results = $results->map(function($user) use ($currentUserId) {
            $friendRequestSent = $user->receivers->contains('sender_id', $currentUserId);
            $friendRequestReceived = $user->senders->contains('receiver_id', $currentUserId);
            $isFriend = $user->friendTo->contains('party1', $currentUserId) || $user->friends->contains('party1', $currentUserId);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'avatar' => $user->avatar,
                'friend_request_sent' => $friendRequestSent,
                'friend_request_received' => $friendRequestReceived,
                'is_friend' => $isFriend,
            ];
        });

        return response()->json($results);
    }

    public static function getFriends(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $results1 = User::find($currentUserId)->friendTo;
        $results2 = User::find($currentUserId)->friends;
        $results = $results1->merge($results2);
        $results = $results->map(function($friend) {
            $user = User::find($friend->party1 === Auth::getUser()->id ? $friend->party2 : $friend->party1);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'avatar' => $user->avatar,
            ];
        });
        return response()->json($results);
    }

    public static function getFriendRequests(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $results = User::find($currentUserId)->receivers;
        $results = $results->map(function($sender) {
            $user = User::find($sender->sender_id);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'avatar' => $user->avatar,
            ];
        });
        return response()->json($results);
    }
}
