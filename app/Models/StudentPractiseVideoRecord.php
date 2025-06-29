<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPractiseVideoRecord extends Model
{
    protected $table = 'student_practise_video_record';
    protected $primaryKey = 'student_practise_video_record_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_practise_video_record_id',
        'student_id',
        'practise_video_id',
        'is_learned',
        'replay_times',
        'is_mastered'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function practiseVideo()
    {
        return $this->belongsTo(PractiseVideo::class, 'practise_video_id', 'practise_video_id');
    }
}
