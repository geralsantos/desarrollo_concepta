<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function theme_groups()
    {
        return $this->hasMany(ThemeGroup::class, 'category_id');
    }
}
