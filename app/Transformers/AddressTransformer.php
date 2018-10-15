<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            'contact_name' => $address->contact_name,
            'contact_phone' => $address->contact_phone,
            'province' => $address->province,
            'city' => $address->city,
            'district' => $address->district,
            'address' => $address->address,
            'fulladdress' => $address->fulladdress,
            'last_used' => $address->last_used_at ? $address->last_used_at->toDateTimeString() : null,
            'default_address' => $address->default_address
        ];
    }
}
