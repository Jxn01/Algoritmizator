<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CompletedLesson
 *
 * The CompletedLesson model represents a lesson that has been completed by a user.
 *
 * Each CompletedLesson is associated with a specific user and lesson.
 * The CompletedLesson records the user who completed the lesson and the lesson that was completed.
 */
class CompletedLesson extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'completed_lessons';

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
        'user_id',
        'lesson_id',
    ];

    /**
     * Get the lesson that the CompletedLesson is associated with.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the user that completed the lesson.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
