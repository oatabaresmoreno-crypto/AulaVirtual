<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
    'course_id',
    'student_id',
    'status',
    'enrolled_at',
    'completed_at',
];

    protected $casts = [
    'enrolled_at'  => 'datetime',
    'completed_at' => 'datetime',
];
}
