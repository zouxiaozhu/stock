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

//
//
//Route::group(['middleware' => 'api.auth'], function () {
//    Route::get('/', function ()    {
//        // 使用 Auth 中间件
//        echo 1111;
//    });
//
//    Route::get('user/profile', function () {
//        // 使用 Auth 中间件
//    });
//});

Route::get('/event_list', 'Api\SyncData\SyncData@eventData');


/**
 * 直接展示给app端,不需要任何验证
 */
Route::group(['namespace' => 'Api\SyncData'], function(){
    Route::group(['prefix' => 'sync'], function(){
        Route::get('event_list', 'SyncData@eventList');                             //财经日志展示
        Route::get('event_detail/{id}', 'SyncData@eventDetail');                    //财经日志详情
        Route::get('news_list', 'SyncData@newsList');                               //财经新闻列表
        Route::get('news_detail/{id}', 'SyncData@newsDetail');                      //财经新闻详情
        Route::get('notice_list', 'SyncData@noticeList');                           //公告列表
        Route::get('notice_detail/{id}', 'SyncData@noticeDetail');                  //公告详情
        Route::get('strong_weak_graph', 'SyncData@strongWeakGraph');                //app首页展示,汇海强弱指数图
        Route::get('ref_bullion', 'SyncData@refBullion');                           //贵金属价位参考表(阻力支持)
        Route::get('ref_forex', 'SyncData@refForex');                               //外汇价位参考表(阻力支持)
        Route::get('econ_list', 'SyncData@econList');                               //经济数据列表
        Route::get('analy_list', 'SyncData@analyList');                             //每日分析最近7天标题
        Route::get('analy_detail/{id}', 'SyncData@analyDetail');                    //每日分析详情
    });
});


/**
 * 后台简单功能curd,后期路由加上登录验证权限
 */
Route::group(['namespace' => 'Backend'], function(){
    Route::group(['prefix' => 'backend'], function() {
        Route::post('about_our/insert', 'AboutOur@insert');                         //关于我们
        Route::put('about_our/update/{id}', 'AboutOur@update');                          //关于我们
        Route::delete('about_our/delete/{id}', 'AboutOur@delete');                       //关于我们
        Route::get('about_our/show', 'AboutOur@show');
    });
});
