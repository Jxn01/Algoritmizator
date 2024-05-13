<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SearchController
 *
 * The SearchController handles actions related to searching for users in the application.
 * This includes searching for users by name or username, getting friends of the current user, and getting friend requests of the current user.
 */
class SearchController extends Controller
{
    /**
     * Search for users.
     *
     * This method searches for users by name or username.
     * It excludes the current user from the search results.
     * It also includes information about whether a friend request has been sent or received, and whether the user is a friend.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The search results.
     */
    public static function search(Request $request)
    {
        $query = $request->input('query');
        if (! $query) {
            return response()->json([]);
        }

        $currentUserId = Auth::getUser()->id;
        $results = User::where('id', '!=', $currentUserId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%'.$query.'%')
                    ->orWhere('username', 'LIKE', '%'.$query.'%');
            })
            ->get();

        $results = $results->map(function ($user) use ($currentUserId) {
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

    /**
     * Get friends of the current user.
     *
     * This method gets the friends of the current user.
     * It includes information about the friend's ID, name, username, total XP, level, and avatar.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The friends of the current user.
     */
    public static function getFriends(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $results1 = User::find($currentUserId)->friendTo;
        $results2 = User::find($currentUserId)->friends;
        $results = $results1->merge($results2);
        $results = $results->map(function ($friend) {
            $user = User::find($friend->party1 === Auth::getUser()->id ? $friend->party2 : $friend->party1);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'avatar' => $user->avatar,
                'is_online' => $user->is_online,
                'last_activity' => $user->last_activity,
                'last_seen_at' => $user->last_seen_at,
                'last_online' => $user->last_online,
            ];
        });

        return response()->json($results);
    }

    public static function getOnlineFriends(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $results1 = User::find($currentUserId)->friendTo;
        $results2 = User::find($currentUserId)->friends;
        $results = $results1->merge($results2);
        $results = $results->map(function ($friend) {
            $user = User::find($friend->party1 === Auth::getUser()->id ? $friend->party2 : $friend->party1);
            if (! $user->is_online) {
                return null;
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'avatar' => $user->avatar,
                'is_online' => $user->is_online,
                'last_activity' => $user->last_activity,
                'last_seen_at' => $user->last_seen_at,
                'last_online' => $user->last_online,
            ];
        });

        $results = $results->filter(function ($friend) {
            return $friend !== null;
        });

        return response()->json($results);
    }

    /**
     * Get friend requests of the current user.
     *
     * This method gets the friend requests of the current user.
     * It includes information about the sender's ID, name, username, total XP, level, and avatar.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The friend requests of the current user.
     */
    public static function getFriendRequests(Request $request)
    {
        $currentUserId = Auth::getUser()->id;
        $results = User::find($currentUserId)->receivers;
        $results = $results->map(function ($sender) {
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

    public static function getUser(Request $request, $id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}
