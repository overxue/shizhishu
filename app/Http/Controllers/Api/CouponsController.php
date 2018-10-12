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

    public function userReceive(Coupon $coupon)
    {
        if (!$coupon->enable) {
            return $this->response->errorNotFound();
        }

        if ($coupon->total - $coupon->used <= 0) {
            return $this->response->error('优惠券以领完', 401);
        }

        //  gt判断第一个日期是否比第二个日期大(Carbon自带函数)
        if ($coupon->not_before && $coupon->not_before->gt(Carbon::now())) {
            return $this->response->error('优惠券还不能领取', 401);
        }

        // lt判断第一个日期是否比第二个日期小
        if ($coupon->not_after && $coupon->not_after->lt(Carbon::now())) {
            return $this->response->error('过期优惠券不能领取', 401);
        }

        if ($this->user()->coupons()->find($coupon->id)) {
            return $this->response->error('优惠券已领取', 401);
        }
        $this->user()->coupons()->attach($coupon);
        $coupon->increment('used');
        return $this->response->created();
    }

    public function userIndex()
    {
        $coupons = $this->user()->coupons()->get();
        dd($coupons);
        return $this->response->collection($coupons, new CouponTransformer);
    }

    public function order(Request $request)
    {
        $total = $this->user()->coupons()->where([
            ['not_after', '>', Carbon::now()],
            ['is_used', 0],
            ['min_amount', '<=', $request->total]
        ])->count();

        return $this->response->array(['tot' => $total]);
    }
}
