<?php

namespace App\Transformers;

use App\Models\Coupon;
use League\Fractal\TransformerAbstract;

class CouponTransformer extends TransformerAbstract
{
    public function transform(Coupon $coupon)
    {
        return [
            'money' => str_replace('.00', '', $coupon->money),
            'description' => $coupon->description,
        ];
    }
}
