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
    Route::get('/user', function(Request $request){
        return $request->user();
    });
    // 取引先
    Route::get('/customer', 'CustomerController@index');
    Route::post('/customer', 'CustomerController@create');
    Route::get('/customer/search', 'CustomerController@search');
});
 
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');
