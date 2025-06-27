<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topic';
    protected $primaryKey = 'topic_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'topic_id',
        'course_id',
        'name',
        'level',
        'number_of_word'
    ];


}
