<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'answers';

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
        'task_id',
        'answer',
        'is_correct',
    ];

    /**
     * Get the task that the answer is associated with.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
