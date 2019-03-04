<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public function themes()
    {
        return $this->hasMany(Theme::class, 'session_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function type()
    {
        return $this->belongsTo(SessionType::class, 'session_type_id');
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class, 'session_id');
    }
}
