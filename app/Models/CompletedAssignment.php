<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedAssignment extends Model
{
    use HasFactory;

    protected $table = "completed_assignments";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        'assignment_id',
        'date'
    ];

    public function assignment()
    {
        return $this->hasOne(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
