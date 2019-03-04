<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public function categories()
    {
        return $this->hasMany(Category::class, 'product_type_id');
    }
}
