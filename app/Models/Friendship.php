<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $table = 'friendships';
    protected $primaryKey = 'id';
    protected $fillable = [
        'party1',
        'party2',
        'date'
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'party1');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'party2');
    }
}
