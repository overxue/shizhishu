<?php
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
        $api->post('code/authorizations', 'AuthorizationsController@codeLogin')
            ->name('api.authorizations.codeLogin');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
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
        // 支付宝后端回调
        $api->post('payment/alipay/notify', 'PaymentsController@alipayNotify')
            ->name('api.payment.notify');
        // 获取首页banner图
        $api->get('banners', 'BannersController@index')
            ->name('api.banners.index');
        // 获取首页优惠券列表
        $api->get('coupons', 'CouponsController@index')
            ->name('api.coupons.index');
        // 获取商品分类   ?include=products  首页商品列表随机获取4个
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        // 商品详情
        $api->get('products/{product}', 'ProductsController@show');
        // 上传图片接口
        $api->post('images', 'ImagesController@store');
        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // 当前登录用户地址列表
            $api->get('user/addresses', 'AddressesController@userIndex')
                ->name('api.addresses.userIndex');
            // 根据 id 获取单个地址
            $api->get('addresses/{address}', 'AddressesController@show')
                ->name('api.addresses.show');
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
            // 下单页面地址
            $api->get('/order/addresses', 'AddressesController@order')
                ->name('api.addresses.order');
            // 领取优惠券
            $api->post('coupons/{coupon}/receives', 'CouponsController@userReceive')
                ->name('api.coupons.receive');
            // 用户已领取的优惠券
            $api->get('user/coupons', 'CouponsController@userIndex')
                ->name('api.coupons.userIndex');
            // 下单页面购物券有几张可用
            $api->post('order/coupons', 'CouponsController@order')
                ->name('api.coupons.order');
            // 添加购物车
            $api->post('carts', 'CartsController@store')
                ->name('api.carts.store');
            // 购物车商品列表
            $api->get('carts', 'CartsController@get')
                ->name('api.carts.get');
            // 删除购物车中的商品
            $api->delete('carts/{cart}', 'CartsController@destory');
            // 购物车商品总数
            $api->get('carts/count', 'CartsController@count')
                ->name('api.carts.count');
            // 下单
            $api->post('orders', 'OrdersController@store')
                ->name('api.orders.store');
            // 订单列表
            $api->get('orders', 'OrdersController@index')
                ->name('api.orders.index');
            // 订单详情
            $api->get('orders/{order}', 'OrdersController@show');
            // 取消订单
            $api->patch('orders/{order}', 'OrdersController@update')
                ->name('api.orders.update');
            // 删除订单
            $api->delete('orders/{order}', 'OrdersController@destroy')
                ->name('api.orders.destory');
            // 订单页面支付
            $api->get('orders/pay/{order}', 'OrdersController@pay')
                ->name('api.orders.pay');
            // 支付宝前端回调
            $api->get('payment/alipay/return', 'PaymentsController@alipayReturn')
                ->name('api.payment.alipayReturn');
        });
    });

    // 后台调用的接口
    $api->group([
        'middleware' => ['api.throttle', 'api.auth'],
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        // 创建banner
        $api->post('admin/banners', 'Admin\BannersController@store');
        // banner 图列表
        $api->get('admin/banners', 'Admin\BannersController@index');
        // 删除banner
        $api->delete('admin/banners/{banner}', 'Admin\BannersController@destroy');
        // 隐藏 banner
        $api->post('admin/banners/{banner}/onShow', 'Admin\BannersController@onShow');
        // 优惠券
        // 获取首页优惠券列表
        $api->get('admin/coupons', 'Admin\CouponsController@index');
        // 添加优惠券
        $api->post('admin/coupons', 'Admin\CouponsController@store');
        // 修改优惠券
        $api->patch('admin/coupons/{coupon}', 'Admin\CouponsController@update');
        // 删除优惠券
        $api->delete('admin/coupons/{coupon}', 'Admin\CouponsController@destroy');
        // 添加商品
        $api->post('admin/products', 'Admin\ProductsController@store');
        // 获取分类列表
        $api->get('admin/categories', 'CategoriesController@index');
        // 获取商品列表
        $api->get('admin/products', 'Admin\ProductsController@index');
        // 删除商品列表
        $api->delete('admin/products/{product}', 'Admin\ProductsController@destroy');
        // 商品上下架
        $api->post('admin/products/{product}/onShow', 'Admin\ProductsController@onShow');
        // 修改商品
        $api->patch('admin/products/{product}', 'Admin\ProductsController@update');
    });
});
