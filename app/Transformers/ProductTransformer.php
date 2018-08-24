<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category'];

    public function transform(Product $product)
    {
        return [
            'id'   => $product->id,
            'title' => $product->title,
            'category_id' => $product->category_id,
            'unit' => $product->unit,
            'rating' => $product->rating,
            'sold_count' => $product->sold_count,
            'review_count' => $product->review_count,
            'price' => $product->price,
            'image' => $product->image,
        ];
    }

    public function includeCategory(Product $product)
    {
        return $this->item($product->category, new CategoryTransformer());
    }
}
