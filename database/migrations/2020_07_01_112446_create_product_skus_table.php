<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_skus', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('SKU 名称');
            $table->string('description')->comment('SKU 描述');
            $table->decimal('sell_price', 10, 2)->comment('卖出 价格');
            $table->decimal('buy_price', 10, 2)->comment('进货 价格');
            $table->unsignedInteger('stock')->comment('SKU 库存');
            $table->decimal('commission',10,2)->comment('佣金');
            $table->unsignedBigInteger('product_id')->comment('所属商品 id');// 外键
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_skus');
    }
}
