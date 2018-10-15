<?php

namespace App\Transformers;

use App\Models\OrderItem;
use League\Fractal\TransformerAbstract;

class OrderItemTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product'];

    public function transform(OrderItem $item)
    {
        return [
            'amount' => $item->amount,
            'price' => $item->price,
        ];
    }

    public function includeProduct(OrderItem $item)
    {
        return $this->item($item->product, new ProductTransformer());
    }
}
