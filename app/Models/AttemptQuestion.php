<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttemptQuestion extends Model
{
    use HasFactory;

    protected $table = 'attempt_questions';

    protected $id = 'id';

    protected $fillable = [
        'task_attempt_id',
        'question_id',
    ];

    public function taskAttempt(): BelongsTo
    {
        return $this->belongsTo(TaskAttempt::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
