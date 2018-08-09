<?php

Route::view('/{query?}', 'pages.index');

Route::get('/users/get/{user}', function (App\Models\User $user) {
    dd($user);
});
