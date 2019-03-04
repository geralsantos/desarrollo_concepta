<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThemeSubGroup extends Model
{
    protected $guarded = [];

    public function theme_group()
    {
        return $this->belongsTo(ThemeGroup::class, 'group_id');
    }

    public function question_subjects()
    {
        return $this->hasMany(QuestionSubject::class, 'sub_group_id');
    }
}
