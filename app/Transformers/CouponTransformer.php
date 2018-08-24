<?php

namespace App\Transformers;

use App\Models\Coupon;
use League\Fractal\TransformerAbstract;

class CouponTransformer extends TransformerAbstract
{
    public function transform(Coupon $coupon)
    {
        return [
            'id' => $coupon->id,
            'money' => str_replace('.00', '', $coupon->money),
            'description' => $coupon->description,
            'expirAt' => $coupon->not_after->toDateString(),
        ];
    }
}
