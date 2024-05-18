<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyAlgorithm extends Model
{
    use HasFactory;

    protected $table = 'hourly_algorithms';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'markdown',
    ];
}
