<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = "assignments";
    protected $primaryKey = "id";
    protected $fillable = [
        'lesson_id',
        'task_id',
        'assignment_xp'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
