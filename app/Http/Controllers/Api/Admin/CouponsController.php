<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Coupon;
use App\Transformers\Admin\CouponTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class CouponsController extends Controller
{
    public function index(Coupon $coupon)
    {
        $coupons = $coupon->all();

        return $this->response->collection($coupons, new CouponTransformer());
    }

    public function store(Request $request, Coupon $coupon)
    {
        $coupon->fill($request->except('date'));
        $coupon->save();

        return $this->response->noContent()->setStatusCode(201);
    }
}
