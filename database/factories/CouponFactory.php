<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Coupon::class, function (Faker $faker) {
    $money = $faker->numberBetween($min = 1, $max = 30);
   //  最低订单金额必须要比优惠金额高
    $minAmount = $money + $faker->numberBetween($min = $money, $max = 30);
    return [
        'money' => $money,
        'min_amount' => $minAmount,
        'total' => $money,
        'not_before' => \Carbon\Carbon::now(),
        'not_after' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+ 1 month')
    ];
});
