<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $primaryKey = "id";
    protected $fillable = [
        'answer_id',
        'description',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
