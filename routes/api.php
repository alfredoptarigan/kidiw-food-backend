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

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});


Route::group(
    [
        'prefix' => 'v1',
        'middleware' => 'auth:api'
    ],
    function () {
        Route::resource('foods', 'FoodController');
        Route::resource('categories',  'CategoryController');
    }
);
