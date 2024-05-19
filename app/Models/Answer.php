<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Answer
 *
 * The Answer model represents an answer to a task in the system.
 *
 * Each answer is associated with a specific task.
 * The Answer records the answer text and whether it is the correct answer for the task.
 */
class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'answer',
        'is_correct',
    ];

    /**
     * Get the task that the answer is associated with.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
