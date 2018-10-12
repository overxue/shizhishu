<?php

Route::view('/{query?}', 'pages.index');

Route::get('/users/get/{user}', function (App\Models\User $user) {
    dd($user);
});
//this.$route.query.uid
Route::get('payment/alipay/return', 'Api\PaymentsController@alipayReturn')->name('payment.alipay.return');
Route::post('payment/alipay/notify', 'Api\PaymentsController@alipayNotify')->name('payment.alipay.notify');
