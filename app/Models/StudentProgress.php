<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    protected $table = 'student_progress';
    protected $primaryKey = 'student_id';
    public $incrementing = false; // Không tự động tăng, vì student_id là chuỗi
    protected $keyType = 'string';
    protected $fillable = [
        'student_id',
        'total_score',
        'word_score',
        'video_score',
        'level'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'student_id');
    }
}
