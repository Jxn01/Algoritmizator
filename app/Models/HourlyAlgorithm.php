<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HourlyAlgorithm
 *
 * The HourlyAlgorithm model represents an algorithm that is displayed hourly on the dashboard.
 *
 * Each hourly algorithm is associated with a title and a markdown description.
 */
class HourlyAlgorithm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'markdown',
    ];
}
