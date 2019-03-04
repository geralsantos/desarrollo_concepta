<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionSubject extends Model
{
    protected $guarded = [];

    public function theme_sub_group()
    {
        return $this->belongsTo(ThemeSubGroup::class, 'sub_group_id');
    }
}
