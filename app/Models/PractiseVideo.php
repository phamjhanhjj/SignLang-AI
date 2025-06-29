<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PractiseVideo extends Model
{
    protected $table = 'practise_video';
    protected $primaryKey = 'practise_video_id';
    public $incrementing = false; // Use string as primary key
    protected $keyType = 'string';
    protected $fillable = [
        'practise_video_id',
        'course_id',
        'video_link',
        'subtitle',
        'score'
    ];
}
