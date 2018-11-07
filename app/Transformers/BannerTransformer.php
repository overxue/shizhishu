<?php

namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{
    public function transform(Banner $banner)
    {
        return [
            'id' => $banner->id,
            'show' => $banner->on_show,
            'imgUrl' => $banner->imgUrl,
            'created_at' => $banner->created_at->toDateTimeString(),
        ];
    }
}
