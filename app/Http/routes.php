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



Route::group(['middleware' => 'api.auth'], function () {
    Route::get('/', function ()    {
        // 使用 Auth 中间件
        echo 1111;
    });

    Route::get('user/profile', function () {
        // 使用 Auth 中间件
    });
});

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
        Route::post('account_regist', 'SyncData@accountRegist');                    //app端开户注册
        Route::post('upload', 'SyncData@upload');                                    //app端上传接口
        Route::post('file_upload', 'SyncData@fileUpload');                          //app上传文件
        Route::post('create_ace', 'SyncData@aceCreate');                            //谁是高手创建接口
        Route::get('ace_list', 'SyncData@aceList');                                 //谁是高手列表
        Route::get('ace_detail/{id}', 'SyncData@aceDetail');                        //谁是高手详情展示
        Route::get('relate_ace/{id}', 'SyncData@relatedAce');                        //谁是高手相关阅读
        Route::get('update_comment_num/{id}', 'SyncData@updateAceCommentNum');       //谁是高手更新评论数
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
        Route::post('open_create', 'openForm@create');                                  //创建下载链接
        Route::put('open_update/{id}', 'openForm@update');                                  //更新下载链接
        Route::get('open_list', 'openForm@openList');                                  //更新下载链接
        Route::delete('open_delete/{id}', 'openForm@openDelete');                                  //更新下载链接
    });
});

//获取融云token
Route::group(['namespace'=> 'Api\Rongyun'], function(){
   Route::post('get_rctoken', 'Rcloud@getToken');
});

Route::post('api/login', 'ApiAuth\AuthTokenController@login');
Route::get('api/check-token', 'ApiAuth\AuthTokenController@checkToken');
Route::post('api/add-comment', 'Api\Comment\CommentController@addComment');
Route::get('api/get-comment', 'Api\Comment\CommentController@getComment');
Route::get('api/get-my-comment', 'Api\Comment\CommentController@getMyComment');

Route::post('admin/login', 'Backend\Admin@login');
Route::get('admin/login', 'Backend\Admin@login');
Route::post('/login', 'Backend\Admin@login');
Route::get('/', 'Backend\Admin@login');

Route::get('admin/home','Backend\Admin@home');
Route::get('admin/logout','Backend\Admin@logout');
Route::get('admin/update-role', 'Backend\Admin@updateRole');
Route::get('admin/lock-user', 'Backend\Admin@lockUser');
Route::get('admin/index-user', 'Backend\UserController@user');
Route::get('admin/add-user', 'Backend\UserController@addUser');
Route::get('admin/edit-user', 'Backend\UserController@addUser');
Route::post('admin/add-user', 'Backend\UserController@updateUser');
Route::get('admin/del-user', 'Backend\UserController@delUser');

Route::post('admin/add-column', 'Backend\Column@updateColumn');
Route::get('admin/add-column', 'Backend\Column@addColumn');
Route::get('admin/edit-column', 'Backend\Column@addColumn');
Route::get('admin/del-column', 'Backend\Column@delColumn');
Route::get('admin/index-column', 'Backend\Column@column');

Route::post('admin/add-role', 'Backend\RoleController@updateRole');
Route::get('admin/add-role', 'Backend\RoleController@addRole');
Route::get('admin/edit-role', 'Backend\RoleController@addRole');
Route::get('admin/del-role', 'Backend\RoleController@delRole');
Route::get('admin/index-role', 'Backend\RoleController@role');


Route::post('admin/add-member', 'Backend\MemberController@updateMember');
Route::get('admin/add-member', 'Backend\MemberController@addMember');
Route::get('admin/edit-member', 'Backend\MemberController@addMember');
Route::get('admin/del-member', 'Backend\MemberController@delMember');
Route::get('admin/index-member', 'Backend\MemberController@member');


Route::get('admin/index-post', 'Backend\Comment@ace');
Route::get('admin/detail-post', 'Backend\Comment@detailAce');
Route::get('admin/audit-ace', 'Backend\Comment@auditAce');
Route::get('admin/audit-comment', 'Backend\Comment@auditComment');


Route::post('service/upload', 'Service\ImagesController@image');