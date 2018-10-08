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
                        ->latest()
                        ->get();
        return $this->response->collection($addresses, new AddressTransformer());
    }

    public function store(AddressRequest $request, Address $address)
    {
        $address->fill($request->except('default_address'));
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

    public function destroy(Address $address)
    {
        $this->authorize('destory', $address);

        $address->delete();
        return $this->response->noContent();
    }

    public function default(Address $address)
    {
        $this->authorize('update', $address);

        $address->where('user_id', $this->user()->id)->update(['default_address' => false]);
        $address->update(['default_address' => true]);
        // update addresses set default_address = (case when id = 3 then 1 else 0 end) where user_id = 5
        return $this->response->item($address, new AddressTransformer());
    }

    public function show(Address $address)
    {
        $this->authorize('show', $address);

        return $this->response->item($address, new AddressTransformer());
    }

    public function order() {
        $address = $this->user()->addresses()
            ->orWhere(function ($query) {
                $query->where('default_address', 1);
            })
            ->whereNotNull('last_used_at')
            ->orderBy('default_address', 'desc')
            ->orderBy('last_used_at', 'desc')
            ->first();

        return $this->response->item($address, new AddressTransformer());
    }
}
