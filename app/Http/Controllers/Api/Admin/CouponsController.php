<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Coupon;
use App\Transformers\Admin\CouponTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class CouponsController extends Controller
{
    public function index(Request $request, Coupon $coupon)
    {
        $coupons = $coupon->paginate($request->current ?? 20);

        return $this->response->paginator($coupons, new CouponTransformer());
    }

    public function store(Request $request, Coupon $coupon)
    {
        $coupon->fill($request->all());
        $coupon->save();

        return $this->response->noContent()->setStatusCode(201);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        return $this->response->noContent();
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return $this->response->noContent();
    }
}
