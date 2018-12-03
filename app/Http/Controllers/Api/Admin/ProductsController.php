<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $products = $product->paginate($request->current ?? 20);

        return $this->response->paginator($products, new ProductTransformer());
    }

    public function store(Request $request, Product $product, ProductImage $productImage)
    {
        $product = \DB::transaction(function () use ($request, $product, $productImage) {
            $res = $this->moveImage('product', $request->image);
            if (!$res) {
                \DB::rollBack();
                return false;
            }
            $product->fill($request->all());
            $product->image = $res;
            $product->save();

            foreach($request->detailUrl as $v) {
                $res = $this->moveImage('productDetail', $v);
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

    public function destroy(Product $product)
    {
        $images = $product->productImages()->get()->pluck('image');
        $product->delete();
        $this->deleteImage($product->image);
        foreach ($images as $v) {
            $this->deleteImage($v);
        }
        return $this->response->noContent();
    }

    public function deleteImage($path)
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function moveImage($type, $path)
    {
        if (File::exists($path)) {
            $folder_name = 'uploads/formal/'.$type.'/'. date('Ym', time()) . '/' . date('d', time()). '/';
            if (!is_dir($folder_name)) {
                File::makeDirectory($folder_name,  $mode = 0777, $recursive = true);
            }
            $full_path = $folder_name.basename($path);
            File::move($path, $full_path);
            return $full_path;
        } else {
            return false;
        }
    }
}
