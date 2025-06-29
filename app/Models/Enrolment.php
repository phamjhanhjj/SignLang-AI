<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table = 'enrolment';
    protected $primaryKey = 'enrolment_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'enrolment_id',
        'course_id',
        'student_id',
        'enrolment_datetime',
        'is_completed'
    ];

    // Define the relationship with Course
    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id', 'course_id');
    }

    // Define the relationship with Student
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'student_id');
    }
}
