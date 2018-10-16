<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['orderItems'];

    public function transform(Order $order)
    {
        if ($order->paid_at) {
            if ($order->refund_status == $order::REFUND_STATUS_PENDING) {
                $status = '已支付';
            } else {
                $status = $order::$refundStatusMap[$order->refund_status];
            }
        } elseif ($order->closed) {
            $status = '交易关闭';
        } else {
            $status = '等待买家付款';
        }
        return [
            'id' => $order->id,
            'no' => $order->no,
            'address' => $order->address,
            'total_amount' => $order->total_amount,
            'remark' => $order->remark,
            'paid_at' => $order->paid_at ? $order->paid_at->toDateTimeString() : null,
            'payment_method' => $order->payment_method,
            'reviewed' => $order->reviewed,
            'order_status' => $status,
        ];
    }

    public function includeOrderItems(Order $order)
    {
        return $this->collection($order->orderItems, new OrderItemTransformer());
    }
}
