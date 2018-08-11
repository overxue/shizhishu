<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('money')->comment('优惠金额');
            $table->decimal('min_amount', 10, 2)->comment('使用该优惠券的最低订单金额');
            $table->unsignedInteger('total')->comment('优惠券总数');
            $table->unsignedInteger('used')->default(0)->comment('已领取数量');
            $table->datetime('not_before')->nullable()->comment('开始时间');
            $table->datetime('not_after')->nullable()->comment('结束时间');
            $table->boolean('enable')->default(true)->comment('是否显示');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
