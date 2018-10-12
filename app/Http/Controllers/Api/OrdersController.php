<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OrderRequest;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function store(OrderRequest $request, Address $address, Order $order, Product $product, OrderItem $orderItem, Coupon $coupon)
    {
        $user = $this->user();
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $request, $address, $order, $product, $orderItem, $coupon) {
            $addresses = $address->find($request->address_id);
            // 更新此地址的最后使用时间
            $addresses->update(['last_used_at' => Carbon::now()]);
            // 创建订单
            $order->fill([
                'address' => [
                    'address' => $addresses->full_address,
                    'contact_name' => $addresses->contact_name,
                    'contact_phone' => $addresses->contact_phone,
                ],
                'remark' => $request->input('remark'),
                'total_amount' => 0
            ]);
            $order->user_id = $user->id;
            $order->save();

            $totalAmount = 0;
            $items = $request->items;
            // 遍历用户提交的商品
            foreach ($items as $data) {
                $products  = $product->find($data['id']);
                // 创建一个 OrderItem 并直接与当前订单关联
                $orderItem->fill([
                    'product_id' => $products->id,
                    'amount' => $data['amount'],
                    'price' => $products->price,
                ]);
                $orderItem->order_id = $order->id;
                $orderItem->save();
                $totalAmount += $products->price * $data['amount'];
            }
            if ($request->coupon) {
                $cou = $coupon->find($request->coupon);
                $mon = $totalAmount >= $cou->min_amount ? $cou->money : 0;
                $this->user()->coupons()->updateExistingPivot($request->coupon, ['is_used' => 1]);
            } else {
                $mon = 0;
            }
            // 更新订单总金额
            $order->update(['total_amount' => sprintf("%.2f", $totalAmount - $mon + 3), 'coupon_id' => $request->coupon]);

            // 将下单的商品从购物车中移除
            $productIds = collect($request->input('items'))->pluck('id');
            $user->carts()->whereIn('product_id', $productIds)->delete();

            return $order;
        });
        
        return app('alipay')->wap([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject' => '食之蔬',
        ]);
    }
}
