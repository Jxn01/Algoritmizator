<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
