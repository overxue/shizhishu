<?php

namespace App\Http\Requests\Api;

class AddressRequest extends FormRequest
{
    public function rules()
    {
        return [
            'province' => 'required|string',
            'city'     => 'required|string',
            'district' => 'required|string',
            'address'  => 'required|string|min:6',
            'contact_name' => 'required|string',
            'contact_phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
            ]
        ];
    }

    public function attributes()
    {
        return [
            'province'  => '省份',
            'city' => '城市',
            'district' => '街道',
            'address' => '详细地址',
            'contact_name' => '联系人',
            'contact_phone' => '手机号'
        ];
    }
}
