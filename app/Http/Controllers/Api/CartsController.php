<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CartRequest;
use App\Models\Cart;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function store(CartRequest $request, Cart $cart)
    {
        // 从数据库中查询该商品是否已经在购物车中
        $carts = $this->user()->carts()->where('product_id', $request->product_id)->first();
        if ($carts) {
            // 如果存在则直接叠加商品数量
            $carts->update([
                'amount' => $carts->amount + $request->amount,
            ]);
        } else {
            $cart->fill($request->all());
            $cart->user_id = $this->user()->id;
            $cart->save();
        }
        return $this->response->noContent()->setStatusCode(201);
    }

    public function get()
    {
        return $this->response->collection($this->user()->carts, new CartTransformer());
    }
}
