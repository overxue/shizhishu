<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['products'];

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'iconfont' => $category->iconfont,
        ];
    }

    public function includeProducts(Category $category)
    {
        $products = $category->products->random(4);
        return $this->collection($products, new ProductTransformer());
    }
}
