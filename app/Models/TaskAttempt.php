<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TaskAttempt
 *
 * The TaskAttempt model represents a user's attempt to complete a task.
 *
 * Each task attempt is associated with a specific attempt and task.
 * The TaskAttempt records the attempt that the user is making and the task that the user is attempting to complete.
 */
class TaskAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attempt_id',
        'task_id',
    ];

    /**
     * Get the attempt that the task attempt is associated with.
     *
     * @return BelongsTo The attempt that the task attempt is associated with.
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    /**
     * Get the task that the user is attempting to complete.
     *
     * @return BelongsTo The task that the user is attempting to complete.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the questions that the user is attempting to answer.
     *
     * @return HasMany The questions that the user is attempting to answer.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(AttemptQuestion::class);
    }
}
