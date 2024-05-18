<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $primaryKey = 'id';

    protected $fillable = [
        'level',
        'xp_start',
        'xp_end',
    ];

    public static function findLevelByXp(int $xp): int
    {
        return self::where('xp_start', '<=', $xp)
            ->where('xp_end', '>=', $xp)
            ->first()
            ->level;
    }
}
