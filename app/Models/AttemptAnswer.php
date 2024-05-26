<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AttemptAnswer
 *
 * The AttemptAnswer model represents an answer given by a user during an attempt at an assignment.
 *
 * Each AttemptAnswer is associated with a specific attempt question and answer.
 * The AttemptAnswer records the attempt made by the user and the answer they provided.
 *
 * @package App\Models
 */
class AttemptAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attempt_question_id',
        'answer_id',
        'custom_answer',
    ];

    /**
     * Get the attempt question that the answer is associated with.
     *
     * @return BelongsTo The attempt question that the answer is associated with.
     */
    public function attemptQuestion(): BelongsTo
    {
        return $this->belongsTo(AttemptQuestion::class);
    }

    /**
     * Get the answer that the user provided.
     *
     * @return BelongsTo The answer that the user provided.
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
