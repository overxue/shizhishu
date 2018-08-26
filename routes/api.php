<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
], function($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        // 账号密码登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 手机验证码登录
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.destroy');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        // 游客可以访问的接口

        // 获取首页banner图
        $api->get('banners', 'BannersController@index')
            ->name('api.banners.index');
        // 获取首页优惠券列表
        $api->get('coupons', 'CouponsController@index')
            ->name('api.coupons.index');
        // 获取商品分类   ?include=products  首页商品列表随机获取4个
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        // 获取商品列表   ?category_id 根据分类获取商品
        $api->get('products', 'ProductsController@index')
            ->name('api.products.index');
        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // 当前登录用户地址列表
            $api->get('user/addresses', 'AddressesController@userIndex')
                ->name('api.addresses.userIndex');
            // 新增地址
            $api->post('addresses', 'AddressesController@store')
                ->name('api.addresses.store');
            // 修改地址
            $api->patch('addresses/{address}', 'AddressesController@update')
                ->name('api.addresses.update');
            // 修改默认地址
            $api->patch('addresses/{address}/default_addresses', 'AddressesController@default')
                ->name('api.addresses.default');
            // 删除地址
            $api->delete('addresses/{address}', 'AddressesController@destroy')
                ->name('api.addresses.destroy');
            // 领取优惠券
            $api->post('coupons/{coupon}/receives', 'CouponsController@userReceive')
                ->name('api.coupons.receive');
            // 用户已领取的优惠券
            $api->get('user/coupons', 'CouponsController@userIndex')
                ->name('api.coupons.userIndex');
        });
    });
});
