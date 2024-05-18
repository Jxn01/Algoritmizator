<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sublesson extends Model
{
    use HasFactory;

    protected $table = 'sublessons';

    protected $id = 'id';

    protected $fillable = [
        'lesson_id',
        'title',
        'markdown',
        'has_quiz',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }
}
