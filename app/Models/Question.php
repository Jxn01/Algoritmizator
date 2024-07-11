<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Question
 *
 * The Question model represents a question in the system.
 *
 * Each question is associated with a specific task.
 * The Question records the markdown content of the question.
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'markdown',
    ];

    /**
     * Get the task that the question is associated with.
     *
     * @return BelongsTo The task that the question belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the answers to the question.
     *
     * @return HasMany The answers associated with the question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
