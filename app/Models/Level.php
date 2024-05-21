<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Level
 *
 * The Level model represents a level in the system.
 *
 * Each level is associated with a range of XP values.
 * The Level records the level number and the range of XP values that correspond to that level.
 */
class Level extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level',
        'xp_start',
        'xp_end',
    ];

    /**
     * Find the level that corresponds to the given XP value.
     */
    public static function findLevelByXp(int $xp): ?int
    {
        return static::where('xp_start', '<=', $xp)
            ->where('xp_end', '>=', $xp)
            ->value('level');
    }
}
