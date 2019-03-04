<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code'];

    public function getInstanceAttribute()
    {
        $instance = null;

        $course = $this->course;
        $exam = $this->exam;
        $simulator = $this->simulator;

        if ($course) {
            $instance = $course;
        } else if ($exam) {
            $instance = $exam;
        } else if ($simulator) {
            $instance = $simulator;
        }

        return $instance;
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'product_id');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'product_id');
    }

    public function simulator()
    {
        return $this->hasOne(Simulator::class, 'product_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'subscriptions', 'product_id', 'student_id');
    }
}
