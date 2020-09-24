<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();

            $table->string('phone')->nullable();
            $table->string('nickname')->nullable();
            $table->boolean('sex')->nullable();
            $table->string('language')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_vip')->default(false)->comment('vip可见佣金&进货价格');
            $table->string('ref_code')->default(false)->comment('邀请码');


            $table->string('wx_openid')->unique()->nullable()->comment('公众号');
            $table->string('ml_openid')->unique()->nullable()->comment('小程序');
            $table->string('unionid')->unique()->nullable()->comment('公众号和小程序的唯一标识');

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
        Schema::dropIfExists('users');
    }
}
