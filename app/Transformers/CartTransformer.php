<?php

namespace App\Transformers;

use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product'];

    public function transform(Cart $cart)
    {
        $price = $cart->product->unit == '斤' ? $cart->product->price / 500 : $cart->product->price;
        return [
            'id' => $cart->id,
            'product_id' => $cart->product_id,
            'amount' => $cart->amount,
            'select' => false,
            'money' => sprintf("%.2f", $price * $cart->amount),
        ];
    }

    public function includeProduct(Cart $cart)
    {
        return $this->item($cart->product, new ProductTransformer());
    }
}
