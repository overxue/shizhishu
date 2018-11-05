<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => substr_replace($user->phone, '****', 3, 4),
            'created_at' => $user->created_at->toDateTimeString(),
        ];
    }
}
