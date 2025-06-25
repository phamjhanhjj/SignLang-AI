<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    public $incrementing = false; // Không tự động tăng, vì course_id là chuỗi
    protected $keyType = 'string';
    protected $fillable = [
        'course_id',
        'nation',
        'total_topic'
    ];
}
