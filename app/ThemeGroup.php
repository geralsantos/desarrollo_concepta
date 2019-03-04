<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThemeGroup extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function theme_sub_groups()
    {
        return $this->hasMany(ThemeSubGroup::class, 'group_id');
    }
}
