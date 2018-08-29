<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class CaptchaRequest extends FormRequest
{
    public function rules()
    {
        $rule = $this->status == 'login' ? 'exists:users' : 'unique:users';
        return [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                $rule,
            ],
            'status' => [
                'required',
                'string',
                Rule::in(['login', 'register']),
            ]
        ];
    }

    public function attributes()
    {
        return [
            'status' => '发送状态'
        ];
    }
}
