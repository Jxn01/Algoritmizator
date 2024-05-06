<?php

namespace App\Models;

use App\Notifications\CustomReset;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed|true $is_online
 */
class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

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
        'level',
        'total_xp',
        'is_online',
        'last_online',
        'avatar',
    ];

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

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomReset($token));
    }

    public static function findById($id)
    {
        return self::where('id', $id)->first();
    }

    public function senders(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receivers(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function completedLessons(): HasMany
    {
        return $this->hasMany(CompletedLesson::class);
    }

    public function completedAssignments(): HasMany
    {
        return $this->hasMany(CompletedAssignment::class);
    }

    public function friendTo(): HasMany
    {
        return $this->hasMany(Friendship::class, 'party1');
    }

    public function friends(): HasMany
    {
        return $this->hasMany(Friendship::class, 'party2');
    }
}
