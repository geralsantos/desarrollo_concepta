<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    protected $hidden = [];
}
