<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    protected $appends = ['correct_responses_names', 'response_templates_json'];

    protected $hidden = [];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function complexity()
    {
        return $this->belongsTo(Complexity::class, 'complexity_id');
    }

    public function response_templates()
    {
        return $this->hasMany(ResponseTemplate::class, 'question_id');
    }

    public function correct_responses()
    {
        return $this->hasMany(CorrectResponse::class, 'question_id');
    }

    public function exercises()
    {
        return $this->belongsToMany(Question::class, 'exercises_questions', 'question_id', 'exercise_id');
    }

    public function exams()
    {
        return $this->belongsToMany(Question::class, 'exams_questions', 'question_id', 'exam_id');
    }

    public function simulator_exams()
    {
        return $this->belongsToMany(Question::class, 'simulator_exams_questions', 'question_id', 'simulator_exam_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Question::class, 'activities_questions', 'question_id', 'activity_id');
    }

    public function subject()
    {
        return $this->belongsTo(QuestionSubject::class, 'subject_id');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'keywords_questions', 'question_id', 'keyword_id');
    }

    public function getCorrectResponsesNamesAttribute()
    {
        return $this->correct_responses->pluck('value');
    }

    public function getResponseTemplatesJsonAttribute()
    {
        return $this->response_templates;
    }
}
