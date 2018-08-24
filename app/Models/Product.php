<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'on_sale' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
