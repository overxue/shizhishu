<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request, Category $category)
    {
        return $this->response->collection($category::all(), new CategoryTransformer($request->type));
    }
}
