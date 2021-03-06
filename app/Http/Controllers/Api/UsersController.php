<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function store(UserRequest $request, User $user)
    {
        $verifyData = \Cache::get($request->verification_key);
        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            return $this->response->errorUnauthorized('验证码错误');
        }

        $users = $user::firstOrNew(['phone' => $verifyData['phone']]);

        if ($users->id) {
            // 清除验证码缓存
            \Cache::forget($request->verification_key);
            return $this->response->error('手机号已存在', 422);
        } else {
            $users->name = $request->name;
            $users->password = bcrypt($request->password);
            $users->save();
        }
        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return $this->response->item($users, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($users),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}
