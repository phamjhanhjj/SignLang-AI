<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearnVideos extends Model
{
    protected $table = 'learn_videos';
    protected $primaryKey = 'learn_video_id';
    public $incrementing = false; // Use string as primary key
    protected $keyType = 'string';
    protected $fillable = [
        'learn_video_id',
        'word_id',
        'video_url'
    ];
}
