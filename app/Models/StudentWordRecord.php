<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentWordRecord extends Model
{
    protected $table = 'student_word_record';
    protected $primaryKey = 'student_word_record_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_word_record_id',
        'student_id',
        'word_id',
        'is_learned',
        'replay_time',
        'is_mastered'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function word()
    {
        return $this->belongsTo(Word::class, 'word_id', 'word_id');
    }
}
