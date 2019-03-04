<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simulator extends Model
{
    protected $guarded = [];

    public function exams()
    {
        return $this->hasMany(SimulatorExam::class, 'simulator_id');
    }

    public function getGroupedExamsAttribute()
    {
        return $this->exams->groupBy('category_id');
    }

    public function attachments()
    {
        return $this->hasMany(SimulatorAttachment::class, 'simulator_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getDurationInMinutesAttribute()
    {
        return $this->duration * 60;
    }
}
