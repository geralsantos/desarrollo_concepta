<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmittedForm extends Model
{
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'form_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
