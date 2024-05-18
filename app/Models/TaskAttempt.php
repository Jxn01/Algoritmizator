<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskAttempt extends Model
{
    use HasFactory;

    protected $table = 'task_attempts';

    protected $id = 'id';

    protected $fillable = [
        'attempt_id',
        'task_id',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AttemptQuestion::class);
    }
}
