<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{env('COMPANY')}}| {{ env('COMPANY_LANG') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->
    <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="../../css/morris/morris.css" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="../../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- fullCalendar -->
    <link href="../../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="../../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="../../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.Js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="/admin/home" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        {{env('HOME')}}
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>  {{session()->get('user_info')['name']}} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{session()->get('user_info')['avatar']  OR ''}}" class="img-circle" alt="User Image"/>
                            <p>
                                {{session()->get('user_info')['name']}}
                                <small>{{date("Y年m月d日 H:i:s")}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{env('APP_URL')}}/admin/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">


        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{session()->get('user_info')['avatar']}}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>Hello,{{session()->get('user_info')['name']}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <ul class="sidebar-menu">
                <?php if (!$prms) {
                    $prms = [];
                }?>
                @foreach($prms as $k=>$prm)
                    @if($prm['name'])
                        <li class="treeview {{$prm['prm']=='post'?'active':''}}">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>{{$prm['name']}}</span>
                                @if($prm['prm'] != 'post')
                                    <i class="fa fa-angle-right pull-right"></i>
                                @else
                                    <i class="fa fa-angle-right pull-down"></i>
                                @endif
                            </a>

                            <ul class="treeview-menu">
                                @if($prm['prm']=='chart')
                                    <li><a href="{{env('APP_URL')}}/admin/edit-jinshu-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增金属</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-waihui-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增外汇{{$prm['name']}}</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-jiaochapan-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增交叉盘{{$prm['name']}}</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-qihuo-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增期货{{$prm['name']}}</a>
                                    </li>
                                @elseif($prm['prm']=='form')
                                    <li><a href="{{env('APP_URL')}}/admin/index-register"><i class="fa fa-angle-double-right"></i> 开户列表</a>
                                    </li>
                                    <li><a href="{{env('APP_URL')}}/admin/index-analog"><i class="fa fa-angle-double-right"></i> 模拟账户列表</a>
                                    </li>
                                    <li><a href="{{env('APP_URL')}}/admin/index-file"><i class="fa fa-angle-double-right"></i>文件列表</a></li>
                                @else
                                    <li><a href="{{env('APP_URL')}}/admin/index-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> {{$prm['name']}}列表</a>
                                    <li><a href="{{env('APP_URL')}}/admin/edit-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增{{$prm['name']}}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="copyrights">Collect from <a href="http://www.cssmoban.com/" title="网站模板">网站模板</a></div>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
           <span>
               <!--- //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ-->
                <button><a href="{{env("APP_URL")}}/admin/index-post?type=0">谁是高手</a></button>
                <button><a href="{{env("APP_URL")}}/admin/index-post?type=1">财经日志</a></button>
                <button><a href="{{env("APP_URL")}}/admin/index-post?type=2">财经新闻公告</a></button>
                <button><a href="{{env("APP_URL")}}/admin/index-post?type=3">经济数据</a></button>
           </span>
        </section>
        <section class="content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                            <div class="box-tools">

                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            @if($type == 0)
                            <table class="table table-hover">
                                <tr>
                                    <th>编号</th>
                                    <th>
                                        产品类型
                                    </th>
                                    <th>操作类型</th>
                                    <th>起始价格</th>
                                    <th>结束价格</th>
                                    <th>止损</th>
                                    <th>创建人</th>
                                    <th>目标</th>
                                    <th>创建时间</th>
                                    <th>评论</th>
                                    <th>状态</th>
                                    <th>
                                        详情
                                    </th>
                                </tr>
<?php $a=['','HKG/港金','LLG/黄金','LLS/白银','EUR/欧元','JPY日元','GBP/英镑','CHF/瑞郎', 'AUD/澳元', 'NZD/纽元','CAD/加元'];
    $b = ['','恒生指数期货','A股指数期货','美元兑人民币（香港）期货','原油','无铅汽油','民用燃料油','天然气','铜','白金','钯','杜斯工业指数','玉米'] ;
    $c= ['', '香港', '美國', '中國'];
?>
                                @foreach($post_list as $key=>$ace)
                                    <tr>
                                        <td>{{$ace['id']}}</td>
                                        <td>
                                        <span class="label label-success">

                                            @if($ace['product_type'][0] == 'a')
                                            {{$a[$ace['product_type'][1]]}}（外汇）
                                                @elseif($ace['product_type'][0] == 'b')
                                                {{$b[$ace['product_type'][1]]}}（期货）
                                                @elseif(($ace['product_type'][0] == 'c'))
                                                {{$c[$ace['product_type'][1]]}}（股票）
                                                @else
                                                ''
                                            @endif
                                        </span>
                                        </td>
                                        @if($ace['action'] == 1)
                                            <td><span class="label label-success">买入</span></td>
                                        @else
                                            <td><span class="label label-warning">卖出</span></td>
                                        @endif
                                        <td>{{$ace['from_price']}}</td>
                                        <td>{{$ace['to_price']}}</td>
                                        <td>{{$ace['stop_loss']}}</td>
                                        <td>{{($ace['create_user_name'])}}</td>
                                        <td>{{($ace['target'])}}</td>
                                        <td>{{date('Y-m-d H:i:s', $ace['create_time'])}}</td>
                                        <td>
                                                {{mb_substr($ace['comment'],0,20)}}...
                                           </td>

                                        <td>
                                            <select name="status" class="audit" ace_id="{{$ace['id']}}">

                                                <option value="1"
                                                @if($ace['rule_result'] ==1)
                                                    selected
                                                        @endif
                                                >通过</option>
                                                <option value="2"
                                                        @if($ace['rule_result'] ==2)
                                                        selected
                                                        @endif
                                                >打回</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{env('APP_URL')}}/admin/detail-post?id={{$ace['id']}}&type={{$type}}" >查看详情</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                                @endif

                                @if($type == 1)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>编号</th>
                                            <th>活动日期</th>
                                            <th>活动开始时间</th>
                                            <th>活动结束时间</th>
                                            <th>标题</th>
                                            <th>创建时间</th>
                                            <th>详情</th>
                                        </tr>

                                        @foreach($post_list as $key=>$event)
                                            <tr>
                                                <td>{{$event['event_id']}}</td>
                                                <td>{{$event['event_date']}}</td>
                                                <td>{{$event['display_start_time']}}</td>
                                                <td>{{$event['display_end_time']}}</td>
                                                <td>{{mb_substr($event['title'],0,20)}}...</td>
                                                <td>{{date('Y-m-d H:i:s',$event['create_time'])}}</td>
                                                <td>
                                                    <a href="{{env('APP_URL')}}/admin/detail-post?id={{$event['event_id']}}&type={{$type}}" >查看详情</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                                @if($type == 2)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>编号</th>
                                            <th>发布时间</th>
                                            <th>分类</th>
                                            <th>图片链接地址</th>
                                            <th>标题</th>
                                            <th>类型</th>
                                            <th>创建时间</th>
                                            <th>详情</th>
                                        </tr>
                                        @if(!empty($post_list))
                                        @foreach($post_list as $key=>$news)
                                            <tr>
                                                <td>{{$news['news_id']}}</td>
                                                <td>{{$news['publish_date_time']}}</td>
                                                <td>{{$news['category']}}</td>
                                                <td>{{unserialize($news['image']) ? unserialize($news['image'])[0] : '' }}</td>

                                                <td><?php
                                                    $a = unserialize($news['headline']);
                                                    if(is_string($a) ){
                                                        echo $a;
                                                    }
                                                    if(is_array($a) && $a){
                                                        echo $a[0];
                                                    }
                                                    if(!$a){
                                                        echo '';}
                                                    ?>...</td>
                                                <td>{{$news['type'] == 1 ? "新闻" : "公告"}}</td>
                                                <td>{{date('Y-m-d H:i:s',$news['create_time'])}}</td>
                                                <td>
                                                    <a href="{{env('APP_URL')}}/admin/detail-post?id={{$news['news_id']}}&type={{$type}}" >查看详情</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                            @endif
                                    </table>
                                @endif

                                @if($type == 3)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>编号</th>
                                            <th>日期</th>
                                            <th>香港时间</th>
                                            <th>国家</th>
                                            <th>经济数据名称</th>
                                            <th>季度</th>
                                            <th>月份</th>
                                            <th>预测</th>
                                            <th>上次结果</th>
                                            <th>公布结果</th>
                                            <th>详情</th>
                                        </tr>

                                        @foreach($post_list as $key=>$econ)
                                            <tr>
                                                <td>{{$econ['id']}}</td>
                                                <td>{{date('Y-m-d H:i:s',$econ['date'])}}</td>
                                                <td>{{$econ['hktime']}}</td>
                                                <td>{{$econ['country']}}</td>
                                                <td>{{$econ['fname'] OR ''}}...</td>
                                                <td>{{$econ['quarter'] OR ''}}</td>
                                                <td>{{$econ['month'] OR ''}}</td>
                                                <td>{{$econ['forecast'] OR ''}}</td>
                                                <td>{{$econ['lasttime'] OR ''}}</td>
                                                <td>{{$econ['value'] OR ''}}</td>
                                                <td>
                                                    <a href="{{env('APP_URL')}}/admin/detail-post?id={{$econ['id']}}&type={{$type}}" >查看详情</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
            {{$post_list->appends(request()->all())->render()}}
        </section>
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- jQuery 2.0.2 -->
<script src="/Js/jquery.min.js"></script>
<script src="/Js/layer/layer.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="/Js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="/Js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="/Js/raphael-min.js"></script>
<script src="/Js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="/Js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="/Js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="/Js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- fullCalendar -->
<script src="/Js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="/Js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="/Js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/Js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="/Js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="/Js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/Js/AdminLTE/dashboard.js" type="text/javascript"></script>
<script>

    $('.audit').change(function () {
        var ace_id = $(this).attr('ace_id');
        var status = $(this).val();
        $.ajax({

            type: "GET",

            url: "{{env('APP_URL')}}"+'/admin/audit-ace',

            data: {ace_id:ace_id, status:status},

            dataType: "json",

            success: function(data){
                console.log(data)
            },
            error:function(){

            }
        });



    });
</script>
</body>
</html>