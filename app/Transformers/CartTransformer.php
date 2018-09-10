<?php

namespace App\Transformers;

use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product'];

    public function transform(Cart $cart)
    {
        return [
            'id' => $cart->id,
            'product_id' => $cart->product_id,
            'amount' => $cart->amount,
            'select' => false,
            'money' => number_format($cart->amount * $cart->product->price, 2, '.', ''),
        ];
    }

    public function includeProduct(Cart $cart)
    {
        return $this->item($cart->product, new ProductTransformer());
    }
}
