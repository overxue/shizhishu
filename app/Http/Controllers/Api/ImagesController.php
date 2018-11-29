<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class ImagesController extends Controller
{
    public function store(Request $request, ImageUploadHandler $image)
    {
//        \Illuminate\Support\Facades\File::move('uploads/images/shop/201811/27/1.jpeg', 'uploads/1.jpeg');
//        die();
        $result = $image->save($request->image, $request->type);
        return $this->response->array($result)->setStatusCode(201);
    }
}
