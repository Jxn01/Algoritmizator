<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = "answers";
    protected $primaryKey = "id";
    protected $fillable = [
        'description',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Task::class);
    }
}
