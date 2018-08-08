<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;
use phpDocumentor\Reflection\Types\Boolean;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            'user_id' => $address->user_id,
            'contact_name' => $address->contact_name,
            'contact_phone' => $address->contact_phone,
            'province' => $address->province,
            'city' => $address->city,
            'district' => $address->district,
            'address' => $address->address,
            'default_address' => (Boolean) $address->default_address
        ];
    }
}
