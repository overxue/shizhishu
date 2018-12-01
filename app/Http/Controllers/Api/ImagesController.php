<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class ImagesController extends Controller
{
    public function store(Request $request, ImageUploadHandler $image)
    {
        $result = $image->save($request->image, $request->type);
        return $this->response->array($result)->setStatusCode(201);
    }
}
