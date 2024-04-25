<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompletedAssignment extends Model
{
    use HasFactory;

    protected $table = 'completed_assignments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'assignment_id',
        'date',
    ];

    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
