<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Sublesson
 *
 * The Sublesson model represents a sublesson in the system.
 *
 * Each sublesson is associated with a specific lesson.
 * The Sublesson records the title, markdown content, and whether it has a quiz.
 */
class Sublesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id',
        'title',
        'markdown',
        'has_quiz',
    ];

    /**
     * Get the lesson that the sublesson is associated with.
     *
     * @return BelongsTo The lesson that the sublesson belongs to.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the quiz associated with the sublesson.
     *
     * @return HasOne The quiz associated with the sublesson.
     */
    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }
}
