<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'task_id',
        'markdown',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
