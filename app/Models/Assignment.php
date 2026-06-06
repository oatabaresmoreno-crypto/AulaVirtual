<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'description',
        'due_date',
        'max_score',
        'active',
    ];

    protected $casts = [
        'due_date'  => 'date',
        'max_score' => 'integer',
        'active'    => 'boolean',
    ];

    // — Relaciones —

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}