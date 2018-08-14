<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => '新鲜蔬菜',
                'iconfont' => '&#xe60e;',
            ],
            [
                'name'        => '鲜肉蛋禽',
                'iconfont' => '&#xe656;',
            ],
            [
                'name'        => '珍鲜荟萃',
                'iconfont' => '&#xe614;',
            ],
            [
                'name'        => '豆制品',
                'iconfont' => '&#xe610;',
            ],
            [
                'name'        => '米面杂粮',
                'iconfont' => '&#xe61b;',
            ],
            [
                'name'        => '粮油调料',
                'iconfont' => '&#xe60f;',
            ],
            [
                'name'        => '酒水饮料',
                'iconfont' => '&#xe60b;',
            ],
            [
                'name'        => '水果世界',
                'iconfont' => '&#xe61d;',
            ]
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
