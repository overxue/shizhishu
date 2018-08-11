<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Transformers\CouponTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index(Coupon $coupon)
    {
        $time = Carbon::now();
        $coupons = $coupon->where([
            ['enable', true],
            ['not_before', '<', $time],
            ['not_after', '>', $time],
        ])->whereRaw('used < total')->get();

        return $this->response->collection($coupons, new CouponTransformer());
    }
}
