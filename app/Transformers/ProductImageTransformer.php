<?php

namespace App\Transformers;

use App\Models\ProductImage;
use League\Fractal\TransformerAbstract;

class ProductImageTransformer extends TransformerAbstract
{
    public function transform(productImage $productImage)
    {
        return [
            'imgUrl' => $productImage->image,
        ];
    }
}
