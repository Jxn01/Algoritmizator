<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'total_xp',
        'is_online',
        'last_online'
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

    public function senders()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receivers()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function blockers()
    {
        return $this->hasMany(BlockedUser::class);
    }

    public function blockedUsers()
    {
        return $this->hasMany(BlockedUser::class, 'blocked_user_id');
    }

    public function completedLessons()
    {
        return $this->hasMany(CompletedLesson::class);
    }

    public function completedAssignments()
    {
        return $this->hasMany(CompletedAssignment::class);
    }

    public function friend()
    {
        return $this->belongsToMany(Friendship::class, 'party1');
    }

    public function friends()
    {
        return $this->hasMany(Friendship::class, 'party2');
    }


}
