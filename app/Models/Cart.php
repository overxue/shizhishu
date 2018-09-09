<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
