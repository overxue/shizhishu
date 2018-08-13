<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->commont('分类id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('title')->commont('商品名称');
            $table->string('image')->commont('商品封面图片');
            $table->string('unit')->commont('商品单位');
            $table->float('rating')->default(5)->commont('评分');
            $table->unsignedInteger('sold_count')->default(0)->commont('销量');
            $table->unsignedInteger('review_count')->default(0)->commont('评论数量');
            $table->decimal('price', 10, 2);
            $table->boolean('on_sale')->default(true)->commont('商品是否上架');
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
        Schema::dropIfExists('products');
    }
}
