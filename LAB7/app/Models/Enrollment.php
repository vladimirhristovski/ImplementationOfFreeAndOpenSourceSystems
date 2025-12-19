<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_name',
        'seats_requested',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
