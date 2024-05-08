<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Attempt
 *
 * The Attempt model represents an attempt made by a user to complete an assignment.
 *
 * Each attempt is associated with a specific user and assignment.
 * The attempt records the total score achieved by the user, the maximum possible score,
 * the time taken to complete the attempt, and whether the attempt was a pass or fail.
 */
class Attempt extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attempts';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'assignment_id',
        'total_score',
        'max_score',
        'time',
        'pass',
    ];

    /**
     * Get the user that owns the attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assignment that the attempt is associated with.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
