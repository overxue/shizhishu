<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OrderRequest;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use App\Jobs\CloseOrder;

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
                $item = $order->orderItems()->make([
                    'amount' => $data['amount'],
                    'price' => $products->price,
                ]);
                $item->product()->associate($products->id);
                $item->order()->associate($order->id);
                $item->save();

                $price = $products->unit == '斤' ? $products->price / 500 : $products->price;
                $totalAmount += $price * $data['amount'];
            }

            if ($request->coupon) {
                $cou = $coupon->find($request->coupon);
                $mon = $totalAmount >= $cou->min_amount ? $cou->money : 0;
                if ($totalAmount >= $cou->min_amount) {
                    $this->user()->coupons()->updateExistingPivot($request->coupon, ['is_used' => 1]);
                }
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
        $this->dispatch(new CloseOrder($order, 1800));
        $alipay = app('alipay')->wap([
                    'out_trade_no' => $order->no,
                    'total_amount' => $order->total_amount,
                    'subject' => '食之蔬',
                ]);
        return $this->response->array([
            'form' => $alipay->getContent(),
            'order_status' => 0
        ]);
    }

    public function index(Order $order)
    {
        $ord = $order->where('user_id', $this->user()->id)->orderBy('created_at', 'desc')->get();

        return $this->response->collection($ord, new OrderTransformer());
    }
}
