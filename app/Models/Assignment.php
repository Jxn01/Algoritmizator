<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Assignment
 *
 * The Assignment model represents an assignment in the system.
 *
 * An assignment is a task or set of tasks given to students as part of their course work.
 * Each assignment belongs to a specific lesson and can have multiple tasks.
 * Students can complete assignments and make attempts at them.
 */
class Assignment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignments';

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
        'lesson_id',
        'title',
        'markdown',
        'assignment_xp',
    ];

    /**
     * Get the lesson that owns the assignment.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the tasks for the assignment.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the completed assignments for the assignment.
     */
    public function completedAssignments(): HasMany
    {
        return $this->hasMany(CompletedAssignment::class);
    }

    /**
     * Get the attempts for the assignment.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }
}
