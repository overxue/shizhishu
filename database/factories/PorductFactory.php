<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $image = [
        "https://s.lovejixiaoyue.cn/images/201707/source_img/146_G_1499041538236.jpg",
        "https://s.lovejixiaoyue.cn/images/201707/source_img/147_G_1499041655081.jpg",
        "https://s.lovejixiaoyue.cn/images/201707/source_img/140_G_1499040352043.jpg",
        "https://s.lovejixiaoyue.cn/images/201707/source_img/150_G_1499043026760.jpg",
        "https://s.lovejixiaoyue.cn/images/201706/source_img/86_G_1498705130097.jpg",
        "https://s.lovejixiaoyue.cn/images/201706/source_img/100_G_1498727357318.jpg",
        "https://s.lovejixiaoyue.cn/images/201706/source_img/112_G_1498729381916.jpg",
        "https://s.lovejixiaoyue.cn/images/201707/source_img/132_G_1498922727271.jpg",
        "https://s.lovejixiaoyue.cn/images/201706/source_img/50_G_1498114519806.jpg",
        "https://s.lovejixiaoyue.cn/images/201706/source_img/68_G_1498620025507.jpg",
    ];
    $unit = ['斤', '件', '袋', '罐', '盒', '箱', '瓶'];
    $ids = \App\Models\Category::all()->pluck('id')->toArray();
    $id = $faker->randomElement($ids);
    return [
        'category_id' => $id,
        'title' => $faker->sentence,
        'image' => $faker->randomElement($image),
        'unit' => $faker->randomElement($unit),
        'price' => $faker->numberBetween($min = 1, $max = 30),
    ];
});
