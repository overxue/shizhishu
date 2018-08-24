<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Transformers\ProductTransformer;

class ProductsController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $query = $product->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        $topics = $query->paginate(10);

        return $this->response->paginator($topics, new ProductTransformer);
    }
}
