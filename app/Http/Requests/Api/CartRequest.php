<?php

namespace App\Http\Requests\Api;

use App\Models\Product;

class CartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => [
                'required',
                function($attribute, $value, $fail) {
                    if (!$product = Product::find($value)) {
                        $fail('商品不存在');
                        return;
                    }
                    if (!$product->on_sale) {
                        $fail('该商品未上架');
                        return;
                    }
                }
            ],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'amount' => '商品数量'
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => '请选择商品'
        ];
    }
}
