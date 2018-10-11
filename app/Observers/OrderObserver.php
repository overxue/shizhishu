<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function saving(Order $order)
    {
        if (!$order->no) {
            // 调用 findAvailableNo 生成订单流水号
            $order->no = $order->findAvailableNo();
            // 如果生成失败，则终止创建订单
            if (!$order->no) {
                return false;
            }
        }
    }
}
