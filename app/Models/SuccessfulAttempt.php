<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuccessfulAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'assignment_id',
        'attempt_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class, 'attempt_id');
    }
}
