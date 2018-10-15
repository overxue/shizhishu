<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['orderItems'];

    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'no' => $order->no,
            'address' => $order->address,
            'total_amount' => $order->total_amount,
            'remark' => $order->remark,
            'paid_at' => $order->paid_at ? $order->paid_at->toDateTimeString() : null,
            'payment_method' => $order->payment_method,
            'reviewed' => $order->reviewed,
        ];
    }

    public function includeOrderItems(Order $order)
    {
        return $this->collection($order->orderItems, new OrderItemTransformer());
    }
}
