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

Route::get('/products/{product}', 'Api\ProductController@show');
Route::get('/products', 'Api\ProductController@all');

Route::post('/login', 'Api\UserController@login');
Route::post('/register', 'Api\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/transaction/initialize', 'Api\TransactionController@initialize');
    Route::post('/transaction/verify', 'Api\TransactionController@verify');
    Route::get('/transaction/user/{id}', 'Api\TransactionController@users');
});