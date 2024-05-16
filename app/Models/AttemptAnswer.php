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
 * Each AttemptAnswer is associated with a specific attempt and answer.
 * The AttemptAnswer records the attempt made by the user and the answer they provided.
 */
class AttemptAnswer extends Model
{
    use HasFactory;

    protected $table = 'attempt_answers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'attempt_question_id',
        'answer_id',
        'custom_answer',
    ];

    public function attemptQuestion(): BelongsTo
    {
        return $this->belongsTo(AttemptQuestion::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
