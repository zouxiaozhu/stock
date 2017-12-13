<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'api.auth'], function () {
    Route::get('/', function ()    {
        // 使用 Auth 中间件
        echo 1111;
    });

    Route::get('user/profile', function () {
        // 使用 Auth 中间件
    });
});

Route::get('/demo', 'Api\SyncData\SyncData@demo');
