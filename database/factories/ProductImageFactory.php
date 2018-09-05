<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ProductImage::class, function (Faker $faker) {
    $images = [
        'https://s.lovejixiaoyue.cn/images/201706/source_img/72_P_1498697749511.jpg',
        'https://s.lovejixiaoyue.cn/images/201706/source_img/74_P_1498698302503.jpg',
        'https://s.lovejixiaoyue.cn/images/201706/source_img/77_P_1498699311103.jpg',
        'https://s.lovejixiaoyue.cn/images/201706/source_img/78_P_1498699492176.jpg',
    ];
    $image = $faker->randomElement($images);
    $product_ids = App\Models\Product::all()->pluck('id')->toArray();
    $id = $faker->randomElement($product_ids);
    return [
        'product_id' => $id,
        'image' => $image,
    ];
});
