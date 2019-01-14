<?php

namespace App\Http\Controllers\Api\Admin;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index(Banner $banner)
    {
        $banners = $banner->get();
        return $this->response->collection($banners, new BannerTransformer());
    }

    public function store(Request $request, Banner $banner, ImageUploadHandler $image)
    {
        $res = $image->moveImage('banner', $request->imgUrl);
        $request['imgUrl'] = $res;
        $banner->fill($request->all());
        $banner->save();

        return $this->response->noContent()->setStatusCode(201);
    }

    public function onShow(Banner $banner, Request $request)
    {
        $banner->update(['on_show' => $request->show]);

        return $this->response->item($banner, new BannerTransformer());
    }
}
