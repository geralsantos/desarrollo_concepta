<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $guarded = [];

    public function getFormattedDurationAttribute()
    {
        $minutes = (int) ($this->duration / 60);
        $seconds = $this->duration % 60;

        return $minutes . ':' . $seconds;
    }

    public function attachments()
    {
        return $this->hasMany(ThemeAttachment::class, 'theme_id');
    }

    public function exams()
    {
        return $this->hasMany(ThemeExam::class, 'theme_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function getDurationInMinutes()
    {
        return (int) ($this->duration / 60);
    }

    public function multimedia()
    {
        return $this->hasMany(ThemeMultimedia::class, 'theme_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'theme_id');
    }
}
