<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'province', 'city', 'district', 'address', 'contact_name',
        'contact_phone', 'default_address', 'last_used_at'
    ];

    protected $dates = ['last_used_at'];
}
