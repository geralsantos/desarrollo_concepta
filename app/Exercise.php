<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exercises_questions', 'exercise_id', 'question_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function variosejercicios(){
    	return $this->belongsTo(GradeCourseExercise::class, 'id');
    }
}
