<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Order $order)
    {
        return $user->isAuthorOf($order);
    }

    public function destroy(User $user, Order $order)
    {
        return $user->isAuthorOf($order);
    }
}
