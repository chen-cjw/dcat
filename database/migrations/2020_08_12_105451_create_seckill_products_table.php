<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeckillProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seckill_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('对应商品表的 ID');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->dateTime('start_at')->comment('秒杀开始时间');
            $table->dateTime('end_at')->comment('秒杀结束时间');
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
        Schema::dropIfExists('seckill_products');
    }
}
