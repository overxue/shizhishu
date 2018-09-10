<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    public function destory(User $user, Cart $cart)
    {
        return $user->isAuthorOf($cart);
    }
}
