<?php

namespace App\Transformers\Admin;

use App\Models\Coupon;
use League\Fractal\TransformerAbstract;

class CouponTransformer extends TransformerAbstract
{
    public function transform(Coupon $coupon)
    {
        return [
            'id' => $coupon->id,
            'money' => str_replace('.00', '', $coupon->money),
            'min_amount' => str_replace('.00', '', $coupon->min_amount),
            'description' => $coupon->description,
            'start_time' => $coupon->not_before->toDateString(),
            'expirAt' => $coupon->not_after->toDateString(),
            'enable' => (boolean) $coupon->enable,
            'created_at' => $coupon->created_at->toDateTimeString(),
            'total' => $coupon->total,
            'used' => $coupon->used,
        ];
    }
}
