<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'word';
    protected $primaryKey = 'word_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'word_id',
        'topic_id',
        'word',
        'meaning',
        'score'
    ];
}
