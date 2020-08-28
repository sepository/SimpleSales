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

Route::middleware('auth:sanctum')->group(function(){
    // ユーザ認証
    Route::get('/user', function(Request $request){
        return $request->user();
    });

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
});
 
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');
