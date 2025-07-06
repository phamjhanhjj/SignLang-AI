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

    protected static function boot()
    {
        parent::boot();

        // Khi tạo mới hoặc cập nhật StudentWordRecord
        static::saved(function ($studentWordRecord) {
            if ($studentWordRecord->is_mastered) {
                // Tìm topic_id từ word_id
                $word = Word::where('word_id', $studentWordRecord->word_id)->first();
                if ($word) {
                    // Tăng current_word trong student_topic_record
                    StudentTopicRecord::where('student_id', $studentWordRecord->student_id)
                        ->where('topic_id', $word->topic_id)
                        ->increment('current_word');
                }
            }
        });

        // Khi xóa StudentWordRecord đã mastered
        static::deleted(function ($studentWordRecord) {
            if ($studentWordRecord->is_mastered) {
                $word = Word::where('word_id', $studentWordRecord->word_id)->first();
                if ($word) {
                    // Giảm current_word
                    StudentTopicRecord::where('student_id', $studentWordRecord->student_id)
                        ->where('topic_id', $word->topic_id)
                        ->decrement('current_word');
                }
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function word()
    {
        return $this->belongsTo(Word::class, 'word_id', 'word_id');
    }
}
