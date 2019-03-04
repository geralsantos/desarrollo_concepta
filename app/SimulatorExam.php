<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulatorExam extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(SimulatorCategory::class, 'category_id');
    }

    public function simulator()
    {
        return $this->belongsTo(Simulator::class, 'simulator_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'simulator_exams_questions', 'simulator_exam_id', 'question_id');
    }
}
