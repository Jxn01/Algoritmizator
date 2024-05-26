<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 *
 * @package App\Models
 */
class Attempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'assignment_id',
        'total_score',
        'max_score',
        'time',
        'passed',
    ];

    /**
     * Get the user that made the attempt.
     *
     * @return BelongsTo The user that made the attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assignment that the attempt is associated with.
     *
     * @return BelongsTo The assignment that the attempt is associated with.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the tasks associated with the attempt.
     *
     * @return HasMany The tasks associated with the attempt.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(TaskAttempt::class);
    }

    /**
     * Get the successful attempts associated with the attempt.
     *
     * @return HasMany The successful attempts associated with the attempt.
     */
    public function successfulAttempts(): HasMany
    {
        return $this->hasMany(SuccessfulAttempt::class);
    }
}
