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
//    'middleware' => ['serializer:array']
], function ($api) {

    $api->get('auth','AuthController@index')->name('api.auth.index');
    $api->post('auth','AuthController@testLogin')->name('api.auth.store');

    // 个人信息
    $api->get('meShow','AuthController@meShow')->name('api.auth.meShow');
    // 退出
    $api->delete('auth/current', 'AuthController@destroy')->name('api.auth.destroy');

    $api->resource('user_addresses', 'UserAddressesController');   // 类型

});
