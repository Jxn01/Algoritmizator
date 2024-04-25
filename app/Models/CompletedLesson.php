<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompletedLesson extends Model
{
    use HasFactory;

    protected $table = 'completed_lessons';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'date',
    ];

    public function lesson(): HasOne
    {
        return $this->hasOne(Lesson::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
