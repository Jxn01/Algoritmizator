<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AttemptQuestion
 *
 * The AttemptQuestion model represents a question that a user is attempting to answer.
 *
 * Each attempt question is associated with a task attempt and a question.
 * The AttemptQuestion records the task attempt that the question is associated with and the question that the user is attempting to answer.
 */
class AttemptQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_attempt_id',
        'question_id',
    ];

    /**
     * Get the task attempt that the question is associated with.
     *
     * @return BelongsTo The task attempt that the question is associated with.
     */
    public function taskAttempt(): BelongsTo
    {
        return $this->belongsTo(TaskAttempt::class);
    }

    /**
     * Get the question that the user is attempting to answer.
     *
     * @return BelongsTo The question that the user is attempting to answer.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the answers that the user has provided for the question.
     *
     * @return HasMany The answers that the user has provided for the question.
     */
    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
