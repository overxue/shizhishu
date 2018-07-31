<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Banner::class, function (Faker $faker) {
    $image = $faker->randomElement([
        'http://oprwd6vhr.bkt.clouddn.com/baner/1.jpg',
        'http://oprwd6vhr.bkt.clouddn.com/baner/2.jpg',
        'http://oprwd6vhr.bkt.clouddn.com/baner/3.jpg',
        'http://oprwd6vhr.bkt.clouddn.com/baner/4.jpg',
    ]);
    return [
        'imgUrl' => $image,
        'on_show' => true,
    ];
});
