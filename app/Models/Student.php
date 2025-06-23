<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_id',
        'email_address',
        'password',
        'username',
        'age',
        'date_of_birth',
        'gender'
    ];

    protected $hidden = [
        'password'
    ];
}
