<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['imgUrl', 'on_show'];

    protected $cats = [
        'on_show' => 'boolean'
    ];
}
