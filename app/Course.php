<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $hidden = [];

    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'course_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function gradeCourse()
    {
        return $this->hasOne(GradeCourse::class, 'course_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'course_id');
    }

    public function getDurationInMinutesAttribute()
    {
        return $this->duration * 60;
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'course_id');
    }

    public function exams()
    {
        return $this->hasMany(CourseExam::class, 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'id');
    }
    
}
