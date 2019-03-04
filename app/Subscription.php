<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'product_id', 'student_id', 'progress', 'attempts',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
