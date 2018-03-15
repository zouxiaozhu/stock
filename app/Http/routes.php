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
        Route::post('account_regist', 'SyncData@accountRegist');                    //app端开户登记
        Route::post('upload', 'SyncData@upload');                                    //app端上传接口
        Route::post('file_upload', 'SyncData@fileUpload');                          //app上传文件
        Route::post('apply_ace', 'SyncData@applyCreateAce');                        //申请ace发帖
        Route::post('create_ace', 'SyncData@aceCreate');                            //谁是高手创建接口
        Route::get('ace_list', 'SyncData@aceList');                                 //谁是高手列表
        Route::get('ace_detail/{id}', 'SyncData@aceDetail');                        //谁是高手详情展示
        Route::get('relate_ace/{id}', 'SyncData@relatedAce');                        //谁是高手相关阅读
        Route::get('update_comment_num/{id}', 'SyncData@updateAceCommentNum');       //谁是高手更新评论数
        Route::get('analy_list', 'SyncData@analyList');                              //每日分析列表
        Route::get('analy_detail/{id}', 'SyncData@analyDetail');                     //每日分析详情
        Route::post('analog_create','SyncData@analogCreate');                        //模拟账号创建
        Route::post('send_mail','SyncData@sendMail');                                //模拟账号创建
        Route::get('screen_price','SyncData@screenPrice');                           //全屏报价
        Route::post('set_price_notice','SyncData@setPriceNotice');                    //设置到价提示
        Route::post('update_price_notice/{id}','SyncData@updatePriceNotice');              //更新到价提示
        Route::get('price_notice_detail/{id}','SyncData@priceNoticeDetail');              //到价提示详情
        Route::get('price_by_product','SyncData@priceByProduct');              //某一个产品的实时报价
        Route::get('my_price_notice','SyncData@myPriceNotice');                    //我的到价提示
        Route::get('del_price_notice/{id}','SyncData@delPriceNotice');                    //删除我的到价提示
        Route::get('app_price_notice','SyncData@appPriceNotice');                    //app端巡通知价格提示
        Route::post('get_member_info','SyncData@getMemberInfo');                    //app端巡通知价格提示
    });
});
Route::post('api/login', 'ApiAuth\AuthTokenController@login');  //登录api
Route::get('api/check-token', 'ApiAuth\AuthTokenController@checkToken');

Route::get('api/get-comment', 'Api\Comment\CommentController@getComment');
// api校验token
Route::group(['middleware' => 'api.auth'], function () {
    Route::post('api/update-member', 'ApiAuth\Member@updateMember');
    Route::post('api/add-comment', 'Api\Comment\CommentController@addComment');
    Route::get('api/get-my-comment', 'Api\Comment\CommentController@getMyComment');
    Route::get('api/get-post', 'Api\Comment\CommentController@getPost');
    Route::get('api/analog-list', 'Api\Comment\CommentController@analogList');
    Route::get('api/account-regist', 'Api\Comment\CommentController@accountRegistList');
    Route::get('api/file-list', 'Api\Comment\CommentController@fileList');
});
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
            Route::post('apply_ace', 'SyncData@applyCreateAce');                        //申请ace发帖
            Route::post('create_ace', 'SyncData@aceCreate');                            //谁是高手创建接口
            Route::get('ace_list', 'SyncData@aceList');                                 //谁是高手列表
            Route::get('ace_detail/{id}', 'SyncData@aceDetail');                        //谁是高手详情展示
            Route::get('relate_ace/{id}', 'SyncData@relatedAce');                        //谁是高手相关阅读
            Route::get('update_comment_num/{id}', 'SyncData@updateAceCommentNum');       //谁是高手更新评论数
            Route::get('analy_list', 'SyncData@analyList');                              //每日分析列表
            Route::get('analy_detail/{id}', 'SyncData@analyDetail');                     //每日分析详情
            Route::post('analog_create','SyncData@analogCreate');                        //模拟账号创建
            Route::post('send_mail','SyncData@sendMail');                                //模拟账号创建
            Route::get('screen_price','SyncData@screenPrice');                           //全屏报价
            Route::post('set_price_notice','SyncData@setPriceNotice');                    //设置到价提示
            Route::post('update_price_notice/{id}','SyncData@updatePriceNotice');              //更新到价提示
            Route::get('my_price_notice','SyncData@myPriceNotice');                    //我的到价提示
            Route::get('del_price_notice/{id}','SyncData@delPriceNotice');                    //删除我的到价提示
            Route::get('app_price_notice','SyncData@appPriceNotice');                    //app端巡通知价格提示
            Route::post('del_table','SyncData@delTable');                                   //
            Route::get('lunbo_index','SyncData@lunboIndex');                                 //轮播图
            Route::get('file_download','SyncData@downloadList');                            //下载列表
            Route::get('bank_info','SyncData@bankInfo');                                    //银行资料
            Route::get('contact_our','SyncData@contactOur');                                //联系我们
            Route::post('add_like','SyncData@addLike');                                      //点赞
            Route::get('comment_like_count','SyncData@countCommentLike');                    //评论数和点赞数统计
            Route::get('ace_permission','SyncData@acePermission');                          //判断发帖权限
        });
    });

Route::get('api/chart','Api\Chart\ChartController@getChart');// 获取技术图表
Route::get('api/destory','Api\Chart\ChartController@destory');// 获取技术图表
Route::get('api/download','Api\Chart\ChartController@setting');// 获取pdf jpg 下载地址
Route::post('api/web-hook','Api\Hook@pull');//




//获取融云token
Route::group(['namespace'=> 'Api\Rongyun'], function(){
   Route::post('get_rctoken', 'Rcloud@getToken');
});


// ADMIN
Route::get('/', 'Backend\Admin@login');
Route::post('admin/login', 'Backend\Admin@login');
Route::get('admin/login', 'Backend\Admin@login');
Route::post('/login', 'Backend\Admin@login');
Route::get('admin/home','Backend\Admin@home');

Route::group(['middleware' => 'admin.auth'], function () {

    // 技术图表
    Route::any('admin/edit-jinshu-chart', 'Backend\Chart@editJinshuChart');
    Route::any('admin/edit-waihui-chart', 'Backend\Chart@editWaihuiChart');
    Route::any('admin/edit-jiaochapan-chart', 'Backend\Chart@editJiaoChaPanChart');
    Route::any('admin/edit-qihuo-chart', 'Backend\Chart@editQiHuoChart');
    // 会员管理
    Route::post('admin/add-member', 'Backend\MemberController@updateMember');
    Route::get('admin/add-member', 'Backend\MemberController@addMember');
    Route::get('admin/edit-member', 'Backend\MemberController@addMember');
    Route::get('admin/del-member', 'Backend\MemberController@delMember');
    Route::get('admin/index-member', 'Backend\MemberController@member');
    Route::get('admin/update-member', 'Backend\MemberController@updateMember');

    Route::get('admin/index-post', 'Backend\Comment@post');
    Route::get('admin/detail-post', 'Backend\Comment@detailPost');
    Route::get('admin/audit-ace', 'Backend\Comment@auditAce');
    Route::get('admin/audit-comment', 'Backend\Comment@auditComment');
    Route::get('admin/edit-post', 'Backend\Comment@editComment');

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
    Route::get('admin/post_infos', 'Backend\Column@post_infos');

    Route::post('admin/add-role', 'Backend\RoleController@updateRole');
    Route::get('admin/add-role', 'Backend\RoleController@addRole');
    Route::get('admin/edit-role', 'Backend\RoleController@addRole');
    Route::get('admin/del-role', 'Backend\RoleController@delRole');
    Route::get('admin/index-role', 'Backend\RoleController@role');

    Route::get('admin/index-setting', 'Backend\Setting@index');
    Route::get('admin/update-setting', 'Backend\Setting@update');
    Route::get('admin/del-setting', 'Backend\Setting@delete');
    Route::get('admin/edit-setting', 'Backend\Setting@index');

    Route::get('admin/index-about', 'Backend\About@about');
    Route::get('admin/del-setting', 'Backend\Setting@delete');


    Route::get('admin/index-download', 'Backend\Download@index');
    Route::any('admin/edit-download', 'Backend\Download@edit');
    Route::get('admin/detail-download', 'Backend\Download@detail');
    Route::get('admin/delete-download', 'Backend\Download@delete');


    Route::get('admin/index-register', 'Backend\Comment@register');
    Route::get('admin/edit-register', 'Backend\Comment@editRegister');
    Route::get('admin/index-file', 'Backend\Comment@file');
    Route::get('admin/edit-file', 'Backend\Comment@editRegister');
    Route::get('admin/index-analog', 'Backend\Comment@analog');
    Route::get('admin/edit-analog', 'Backend\Comment@editRegister');


    /**
     * 后台简单功能curd,后期路由加上登录验证权限
     */
    Route::group(['namespace' => 'Backend'], function(){
        Route::group(['prefix' => 'backend'], function() {
            Route::post('about_our/insert', 'AboutOur@insert');                              //关于我们
            Route::put('about_our/update/{id}', 'AboutOur@update');                          //关于我们
            Route::delete('about_our/delete/{id}', 'AboutOur@delete');                       //关于我们
            Route::get('about_our/show', 'AboutOur@show');
            Route::post('open_create', 'openForm@create');                                  //创建下载链接
            Route::put('open_update/{id}', 'openForm@update');                                  //更新下载链接
            Route::get('open_list', 'openForm@openList');                                  //更新下载链接
            Route::delete('open_delete/{id}', 'openForm@openDelete');                                  //更新下载链接
        });
    });


});

Route::post('service/upload', 'Service\ImagesController@image');
Route::any('api/pull', 'Api\Hook@pull');
Route::any('api/test', 'Api\Hook@test');