<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationsRequest;
use Illuminate\Http\Request;
use Auth;
use App\Transformers\UserTransformer;
use App\Models\User;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationsRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;
        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        return $this->response->item(Auth::guard('api')->user(), new UserTransformer())
            ->setMeta($this->respondWithToken($token)->original)
            ->setStatusCode(201);
    }

    public function codeLogin(Request $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }
        $user = User::where('phone', $verifyData['phone'])->first();
        // 清除验证码缓存
        \Cache::forget($request->verification_key);
        if ($user) {
            return $this->response->item($user, new UserTransformer())
                ->setMeta($this->respondWithToken(\Auth::guard('api')->fromUser($user))->original)
                ->setStatusCode(201);
        } else {
            return $this->response->error('手机号未注册', 422);
        }
    }

    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
