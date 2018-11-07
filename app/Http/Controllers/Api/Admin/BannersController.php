<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Transformers\BannerTransformer;

class BannersController extends Controller
{
    public function index(Banner $banner)
    {
        $banners = $banner->get();

        return $this->response->collection($banners, new BannerTransformer());
    }
}
