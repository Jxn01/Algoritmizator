<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FriendRequest
 *
 * The FriendRequest model represents a friend request in the system.
 *
 * Each friend request is associated with a sender and a receiver.
 * The FriendRequest records the user who sent the request and the user who received the request.
 */
class FriendRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
    ];

    /**
     * Get the user who sent the friend request.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who received the friend request.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
