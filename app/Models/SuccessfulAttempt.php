<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SuccessfulAttempt
 *
 * The SuccessfulAttempt model represents a successful attempt at an assignment by a user.
 *
 * Each successful attempt is associated with a specific user, assignment, and attempt.
 * The SuccessfulAttempt records the user who successfully completed the assignment and the attempt they made.
 */
class SuccessfulAttempt extends Model
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
        'attempt_id',
    ];

    /**
     * Get the user who successfully completed the assignment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the assignment that was successfully completed.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    /**
     * Get the attempt that was successfully completed.
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class, 'attempt_id');
    }
}
