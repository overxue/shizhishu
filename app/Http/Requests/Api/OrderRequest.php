<?php

namespace App\Http\Requests\Api;

use App\Models\Product;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 判断用户提交的地址 ID 是否存在于数据库并且属于当前用户
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where('user_id', $this->user()->id),
            ],
            'items' => ['required', 'array'],
            'items.*.amount' => ['required', 'integer', 'min:1'],
            'items.*.id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$product = Product::find($value)) {
                        $fail('商品不存在');
                        return;
                    }
                    if (!$product->on_sale) {
                        $fail('该商品已下架');
                        return;
                    }
                }
            ]
        ];
    }
}
