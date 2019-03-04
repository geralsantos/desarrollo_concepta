<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;;

class Company extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [];

    public function subscriptions()
    {
        return $this->belongsToMany(Product::class, 'companies_subscriptions', 'company_id', 'product_id');
    }

    public function getCoursesAttribute()
    {
        return $this->subscriptions()->with('course')->whereHas('course')->get();
    }

    public function getExamsAttribute()
    {
        return $this->subscriptions()->with('exam')->whereHas('exam')->get();
    }

    public function getSimulatorsAttribute()
    {
        return $this->subscriptions()->with('simulator')->whereHas('simulator')->get();
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'company_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }
}
