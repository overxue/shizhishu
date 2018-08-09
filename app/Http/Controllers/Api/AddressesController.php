<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AddressRequest;
use App\Models\Address;
use App\Transformers\AddressTransformer;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function userIndex()
    {
        $addresses = $this->user()->addresses()
                        ->orderBy('default_address', 'desc')
                        ->orderBy('last_used_at', 'desc')
                        ->get();
        return $this->response->collection($addresses, new AddressTransformer());
    }

    public function store(AddressRequest $request, Address $address)
    {
        $address->fill($request->all());
        $address->user_id = $this->user()->id;
        $address->save();

        return $this->response->item($address, new AddressTransformer())
            ->setStatusCode(201);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);

        $address->update($request->all());
        return $this->response->item($address, new AddressTransformer());
    }
}
