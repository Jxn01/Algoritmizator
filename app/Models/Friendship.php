<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Friendship
 *
 * The Friendship model represents a friendship between two users in the system.
 *
 * Each friendship is associated with two users.
 * The Friendship records the two users who are friends.
 */
class Friendship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'party1',
        'party2',
    ];

    /**
     * Get the first user in the friendship.
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'party1');
    }

    /**
     * Get the second user in the friendship.
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'party2');
    }
}
