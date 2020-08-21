<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array']
], function ($api) {

    $api->get('auth','AuthController@index')->name('api.auth.index');
    $api->post('auth','AuthController@testLogin')->name('api.auth.store');
//    $api->post('auth','AuthController@store')->name('api.auth.store');

    // 登陆 绑定路由，可依赖注入获取id
    $api->group(['middleware' => ['bindings']], function ($api) {

        $api->group(['middleware' => ['auth:api']], function ($api) {

            $api->get('meShow', 'AuthController@meShow')->name('api.auth.meShow');// 个人信息
            $api->delete('auth/current', 'AuthController@destroy')->name('api.auth.destroy');// 退出
            $api->resource('user_addresses', 'UserAddressesController');   // 地址

            $api->get('products/favorites', 'ProductsController@favorites')->name('api.products.favorites');// 收藏列表
            $api->post('products/{product}/favorite', 'ProductsController@favor')->name('api.products.favor');// 收藏商品
            $api->delete('products/{product}/favorite', 'ProductsController@disfavor')->name('api.products.disfavor');// 取消收藏
            // 添加购物车
            $api->get('carts', 'CartController@index')->name('api.carts.index');
            $api->post('carts', 'CartController@store')->name('api.carts.store');
            $api->delete('carts/{sku}', 'CartController@destroy')->name('api.carts.destroy');

            // 提交订单
            $api->get('orders', 'OrdersController@index')->name('api.orders.index');
            $api->get('orders/{order}', 'OrdersController@show')->name('api.orders.show');
            $api->post('orders', 'OrdersController@store')->name('api.orders.store');


        });

        $api->get('products', 'ProductsController@index')->name('api.products.index'); // 商品列表
        $api->get('products/{product}', 'ProductsController@show')->name('api.products.show'); // 商品详情
    });

});
