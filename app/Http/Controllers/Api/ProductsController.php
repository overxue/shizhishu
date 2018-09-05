<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Transformers\ProductTransformer;

class ProductsController extends Controller
{
    public function show(Product $product)
    {
        return $this->response->item($product, new ProductTransformer());
    }
}
