<?php

namespace App\Models;

use App\Notifications\CustomReset;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * The User model represents a user in the system.
 *
 * Each user has a name, username, email, password, level, total experience, online status, last online time, and avatar.
 * The User model also implements CanResetPassword and MustVerifyEmail contracts.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'total_xp',
        'is_online',
        'last_online',
        'avatar',
    ];

    protected $appends = ['level'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getLevelAttribute(): int
    {
        return Level::findLevelByXp($this->total_xp);
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomReset($token));
    }

    /**
     * Find a user by their ID.
     */
    public static function findById(int $id): User
    {
        return self::where('id', $id)->first();
    }

    /**
     * Get the friend requests sent by the user.
     */
    public function senders(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    /**
     * Get the friend requests received by the user.
     */
    public function receivers(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    /**
     * Get the friendships where the user is the first party.
     */
    public function friendTo(): HasMany
    {
        return $this->hasMany(Friendship::class, 'party1');
    }

    /**
     * Get the friendships where the user is the second party.
     */
    public function friends(): HasMany
    {
        return $this->hasMany(Friendship::class, 'party2');
    }

    /**
     * Get the attempts made by the user.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }

    /**
     * Get the successful attempts made by the user.
     */
    public function successfulAttempts(): HasMany
    {
        return $this->hasMany(SuccessfulAttempt::class);
    }
}
