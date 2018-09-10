<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Address $address)
    {
        return $user->isAuthorOf($address);
    }

    public function destory(User $user, Address $address)
    {
        return $user->isAuthorOf($address);
    }
}
