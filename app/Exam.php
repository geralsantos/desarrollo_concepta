<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    public function attachments(){
        return $this->hasMany(ExamAttachment::class, 'exam_id');
    }

    public function getDurationInMinutesAttribute()
    {
        return $this->duration;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exams_questions', 'exam_id', 'question_id');
    }

    public function category()
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }
}
