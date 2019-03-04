<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeCourse extends Model
{	
	protected $hidden = [];
	protected $guarded = [];

    public function course(){

    	return $this->belongsTo(Course::class, 'course_id');
    }

    public function alumno(){
    	return $this->belongsTo(Student::class, 'student_id');
    }
}
