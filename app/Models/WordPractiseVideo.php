<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordPractiseVideo extends Model
{
    protected $table = 'word_practise_video';
    protected $primaryKey = 'word_practise_video_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'word_practise_video_id',
        'word_id',
        'practise_video_id',
    ];

    // Define the relationship with Word
    public function word()
    {
        return $this->belongsTo(Word::class, 'word_id', 'word_id');
    }

    // Define the relationship with PractiseVideo
    public function practiseVideo()
    {
        return $this->belongsTo(PractiseVideo::class, 'practise_video_id', 'practise_video_id');
    }
}
