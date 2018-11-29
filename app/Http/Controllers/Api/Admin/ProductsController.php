<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class ProductsController extends Controller
{
    public function store(Request $request, Product $product)
    {
        dd($request->all());
    }
}
