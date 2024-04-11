<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = "lessons";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'description'
    ];

    public function assignments()
    {
        return $this->hasOne(Assignment::class);
    }

    public function completedLessons()
    {
        return $this->belongsToMany(CompletedLesson::class);
    }
}
