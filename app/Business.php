<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    public function company()
    {
        return $this->hasOne(Company::class, 'business_id');
    }

    public function products()
    {
        return $this->belongsTomany(Product::class, 'businesses_products', 'business_id', 'product_id', 'max_students');
    }

    public function getCoursesAttribute()
    {
        return $this->products()->with('course')->withPivot('max_students')->whereHas('course')->get();
    }

    public function getSimulatorsAttribute()
    {
        return $this->products()->with('simulator')->withPivot('max_students')->whereHas('simulator')->get();
    }

    public function getExamsAttribute()
    {
        return $this->products()->with('exam')->withPivot('max_students')->whereHas('exam')->get();
    }
}
