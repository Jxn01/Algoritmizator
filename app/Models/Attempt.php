<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Attempt
 *
 * The Attempt model represents an attempt made by a user to complete an assignment.
 *
 * Each attempt is associated with a specific user and assignment.
 * The attempt records the total score achieved by the user, the maximum possible score,
 * the time taken to complete the attempt, and whether the attempt was a pass or fail.
 */
class Attempt extends Model
{
    protected $fillable = [
        'user_id',
        'assignment_id',
        'total_score',
        'max_score',
        'time',
        'passed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function tasks(): hasMany
    {
        return $this->hasMany(TaskAttempt::class);
    }

    public function successfulAttempts(): hasMany
    {
        return $this->hasMany(SuccessfulAttempt::class);
    }
}
