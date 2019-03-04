<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeCourseExercise extends Model
{
    protected $hidden = [];
	protected $guarded = [];

	public function notas(){

		return $this->hasMany(Exercise::class);
	}

}
