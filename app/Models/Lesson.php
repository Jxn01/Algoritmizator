<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Lesson
 *
 * The Lesson model represents a lesson in the system.
 *
 * Each lesson can have a title and a description.
 * A lesson can have one assignment and multiple completed lessons.
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lessons';

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
        'title',
    ];

    /**
     * Find a lesson by its title.
     *
     * @param string $title
     * @return Lesson
     */
    public function findLessonByTitle(string $title): Lesson
    {
        return $this->where('title', $title)->first();
    }

    /**
     * Get the assignment associated with the lesson.
     */
    public function assignments(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }

    /**
     * Get the completed lessons for the lesson.
     */
    public function completedLessons(): HasMany
    {
        return $this->hasMany(CompletedLesson::class);
    }

    /**
     * Get the sublessons for the lesson.
     */
    public function sublessons(): HasMany
    {
        return $this->hasMany(Sublesson::class);
    }
}
