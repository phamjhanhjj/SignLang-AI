<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'student_id';
    public $incrementing = false; // Không tự động tăng, vì student_id là chuỗi
    protected $keyType = 'string';
    protected $fillable = [
        'student_id',
        'email_address',
        'password',
        'username',
        'age',
        'date_of_birth',
        'gender'
    ];

    protected $hidden = [
        'password'
    ];

    // Tự động tạo StudentProgress khi Student được tạo
    protected static function booted()
    {
        static::created(function ($student) {
            \App\Models\StudentProgress::create([
                'student_id' => $student->student_id,
            ]);
        });
    }
}
