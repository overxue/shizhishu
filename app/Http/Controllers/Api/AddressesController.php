<?php

namespace App\Http\Controllers\Api;

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
}
