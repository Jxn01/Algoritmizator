<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedLesson extends Model
{
    use HasFactory;

    protected $table = 'completed_lessons';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'lesson_id',
        'date'
    ];

    public function lesson()
    {
        return $this->hasOne(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
