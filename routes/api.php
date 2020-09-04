<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// 認証済ユーザ取得
Route::get('/user', function(Request $request) {
    return Auth::user();
});

// 認証不要
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');

// 認証必須
Route::middleware('auth:sanctum')->group(function() {
    // ユーザ
    Route::get('/user/list', 'UserController@index');
    Route::get('/user/search', 'UserController@search');
    Route::get('/user/profile/{user}', 'UserController@show');

    // 取引先
    Route::get('/customer', 'CustomerController@index');
    Route::post('/customer', 'CustomerController@create');
    Route::get('/customer/search', 'CustomerController@search');
    Route::get('/customer/{customer}', 'CustomerController@show');
    Route::put('/customer/{customer}', 'CustomerController@update');
    Route::delete('/customer/{customer}', 'CustomerController@destroy');

    // 商品
    Route::get('/product', 'ProductController@index');
    Route::post('/product', 'ProductController@create');
    Route::get('/product/search', 'ProductController@search');
    Route::get('/product/{product}', 'ProductController@show');
    Route::put('/product/{product}', 'ProductController@update');
    Route::delete('/product/{product}', 'ProductController@destroy');

    // 単位
    Route::get('/unit', 'UnitController@index');
    Route::post('/unit', 'UnitController@create');
    Route::put('/unit/{unit}', 'UnitController@update');
});
 
// 認証必須且つ管理者権限
Route::middleware('auth:sanctum', 'can:admin-only')->group(function() {
    // ユーザ
    Route::post('/user/register', 'Auth\RegisterController@register');
    Route::put('/user/suspend/{user}', 'UserController@suspend');
    Route::put('/user/resume/{user}', 'UserController@resume');
});