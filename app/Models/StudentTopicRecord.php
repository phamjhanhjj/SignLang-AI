<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTopicRecord extends Model
{
    protected $table = 'student_topic_record';
    // Bỏ composite primary key vì Laravel không hỗ trợ native
    // protected $primaryKey = ['student_id', 'topic_id']; // Composite key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        // 'student_topic_record_id',
        'student_id',
        'topic_id',
        'is_completed',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'topic_id');
    }
}
