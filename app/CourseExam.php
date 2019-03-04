<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseExam extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'course_exams_questions', 'course_exam_id', 'question_id');
    }
}
