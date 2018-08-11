<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'money', 'min_amount', 'total', 'not_before', 'not_after', 'enable'
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
    // 指明这两个字段是日期类型
    protected $dates = ['not_before', 'not_after'];

    public function getDescriptionAttribute()
    {
        $str = '满'.str_replace('.00', '', $this->min_amount);
        return $str.'减'.str_replace('.00', '', $this->money);
    }
}
