<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'party1');
    }

    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'party2');
    }
}
