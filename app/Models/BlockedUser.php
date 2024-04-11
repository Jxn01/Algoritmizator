<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    use HasFactory;

    protected $table = 'blocked_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'blocked_user_id',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
