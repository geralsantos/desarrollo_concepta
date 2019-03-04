<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
