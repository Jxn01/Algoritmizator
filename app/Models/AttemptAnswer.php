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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attempt_answers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_attempt_id',
        'answer_id',
    ];

    /**
     * Get the attempt that the AttemptAnswer is associated with.
     */
    public function taskaAtempt(): BelongsTo
    {
        return $this->belongsTo(TaskAttempt::class);
    }

    /**
     * Get the answer that the AttemptAnswer is associated with.
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
