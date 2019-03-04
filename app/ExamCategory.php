<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    protected $guarded = [];

    public function exams()
    {
        return $this->hasMany(Exam::class, 'category_id');
    }
}
