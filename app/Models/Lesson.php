<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function assignments(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }

    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(CompletedLesson::class);
    }
}
