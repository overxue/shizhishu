<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index(Banner $banner)
    {
        $image = $banner->where('on_show', true)->get();

        return $this->response->collection($image, new BannerTransformer());
    }
}
