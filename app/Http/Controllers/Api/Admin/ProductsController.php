<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Handlers\ImageUploadHandler;

class ProductsController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $products = $product->paginate($request->current ?? 20);

        return $this->response->paginator($products, new ProductTransformer());
    }

    public function store(Request $request, Product $product, ProductImage $productImage, ImageUploadHandler $image)
    {
        $product = \DB::transaction(function () use ($request, $product, $productImage, $image) {
            $res = $image->moveImage('product', $request->image);
            if (!$res) {
                \DB::rollBack();
                return false;
            }
            $product->fill($request->all());
            $product->image = $res;
            $product->save();

            foreach($request->detailUrl as $v) {
                $res = $image->moveImage('productDetail', $v['imgUrl']);
                if (!$res) {
                    \DB::rollBack();
                    return false;
                }
                $item = $productImage->make(['image' => $res, 'product_id' => $product->id]);
                $item->save();
            }
            return true;
        });
        if ($product) {
            return $this->response->noContent()->setStatusCode(201);
        } else {
            return $this->response->error('图片不存在', 401);
        }
    }

    public function destroy(Product $product, ImageUploadHandler $image)
    {
        $images = $product->productImages()->get()->pluck('image');
        $product->delete();
        $image->deleteImage($product->image);
        foreach ($images as $v) {
            $image->deleteImage($v);
        }
        return $this->response->noContent();
    }

    public function onShow(Product $product)
    {
        $product->on_sale = !$product->on_sale;
        $product->save();

        return $this->response->noContent();
    }

    public function update(Request $request, Product $product, ProductImage $productImage, ImageUploadHandler $image)
    {
        $product = \DB::transaction(function () use ($request, $product, $productImage, $image) {
            if ($request->image != $product->image) {
                $res = $image->moveImage('product', $request->image);
                if (!$res) {
                    \DB::rollBack();
                    return false;
                }
                $image->deleteImage($product->image);
                $request['image'] = $res;
            }
            $product->update($request->all());
            $productDetail = $product->productImages->pluck('image')->all();
            $product->productImages()->delete();
            foreach($request->detailUrl as $v) {
                if (in_array($v['imgUrl'], $productDetail)) {
                    // 在数组里
                    $productDetail = array_diff($productDetail, [$v['imgUrl']]);
                    $res = $v['imgUrl'];
                } else {
                    $res = $image->moveImage('productDetail', $v['imgUrl']);
                    if (!$res) {
                        \DB::rollBack();
                        return false;
                    }
                }
                $item = $productImage->make(['image' => $res, 'product_id' => $product->id]);
                $item->save();
            }
            if (!empty($productDetail)) {
                foreach($productDetail as $value) {
                    $this->deleteImage($value);
                }
            }
            return true;
        });
        if ($product) {
            return $this->response->noContent()->setStatusCode(201);
        } else {
            return $this->response->error('图片不存在', 401);
        }
    }


}
