<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThemeMultimedia extends Model
{
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(MultimediaType::class, 'multimedia_type_id');
    }
}
