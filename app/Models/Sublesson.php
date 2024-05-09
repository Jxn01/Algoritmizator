<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sublesson extends Model
{
    use HasFactory;

    protected $table = 'sublessons';

    protected $id = 'id';

    protected $fillable = [
        'lesson_id',
        'title',
        'markdown',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
