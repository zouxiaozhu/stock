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
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../../img/avatar3.png" class="img-circle" alt="User Image"/>
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning danger"></i> Very long description here that may not fit
                                        into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users warning"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="ion ion-ios7-cart success"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="ion ion-ios7-person danger"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>  {{session()->get('user_info')['name']}} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{session()->get('user_info')['avatar']  OR ''}}" class="img-circle"
                                 alt="User Image"/>
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
    <aside class="left-side sidebar-offcanvas">

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
            <!-- search form -->

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
                                    <li><a href="{{env('APP_URL')}}/admin/edit-jinshu-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> 新增金属</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-waihui-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> 新增外汇{{$prm['name']}}</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-jiaochapan-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> 新增交叉盘{{$prm['name']}}</a>
                                    </li>

                                    <li><a href="{{env('APP_URL')}}/admin/edit-qihuo-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> 新增期货{{$prm['name']}}</a>
                                    </li>

                                @elseif($prm['prm']=='form')
                                    <li><a href="{{env('APP_URL')}}/admin/index-register"><i class="fa fa-angle-double-right"></i> 开户列表</a>
                                    </li>
                                    <li><a href="{{env('APP_URL')}}/admin/index-analog"><i class="fa fa-angle-double-right"></i> 模拟账户列表</a>
                                    </li>
                                    <li><a href="{{env('APP_URL')}}/admin/index-file"><i class="fa fa-angle-double-right"></i>文件列表</a></li>
                                @else

                                    <li><a href="{{env('APP_URL')}}/admin/index-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> {{$prm['name']}}列表</a>
                                    <li><a href="{{env('APP_URL')}}/admin/edit-{{$prm['prm']}}"><i
                                                    class="fa fa-angle-double-right"></i> 新增{{$prm['name']}}</a>
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
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                谁是高手
                <small>preview of ace manage</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>HOME</a></li>
                <li><a href="#">帖子</a></li>
                <li class="active">详情</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="col-xs-12 bg-black-gradient">
                            @if($type == 0)
                                <ul>
                                    <li>{{$detail['comment']}}</li>
                                </ul>

                            @endif

                            @if($type == 1)
                                <i class=""> 帖子内容 </i>
                                <ul>
                                    <li>标题：{{$detail['title']}}</li>
                                    <li>活动日期：{{$detail['event_date']}}</li>
                                    <li>活动开始时间：{{$detail['display_start_time']}}</li>
                                    <li>活动结束时间：{{$detail['display_end_time']}}</li>
                                </ul>

                            @endif
                            @if($type == 2)
                                <ul>
                                    <li>标题：{{$detail['title']}}</li>
                                    <li>发布时间：{{date('Y-m-d H:i:s',$detail['publish_date_time'])}}</li>
                                    <li>分类：{{$detail['category']}}</li>

                                </ul>
                            @endif
                            @if($type == 3 && $detail)
                                <ul>
                                    <li>日期：{{date('Y-m-d H:i:s',$detail['date'])}}</li>
                                    <li>香港时间：{{$detail['hktime']}}</li>
                                    <li>国家：{{$detail['country']}}</li>
                                    <li>经济数据名称：{{$detail['fname']}}</li>
                                    <li>季度：{{$detail['quarter']}}</li>
                                    <li>月份：{{$detail['month']}}</li>
                                    <li>预测：{{$detail['forecast']}}</li>
                                    <li>上次结果：{{$detail['lasttime']}}</li>
                                    <li>公布结果公布结果：{{$detail['value']}}</li>

                                </ul>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
            {{--            {{$ace_list->appends(request()->all())->render()}}--}}
        </section>

        <section>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">

                    @foreach($comment_page as $comment)
                        <ul class="menu">
                            <li><!-- start message -->
                                <a href="#">
                                    <h4>
                                        {{$comment['content']}}
                                        <small><i class="fa fa-clock-o"></i>
                                            时间 : {{$comment['create_at']}} {{$comment['id']}}
                                        </small>
                                        <select class="small" name="fa" com_id="{{$comment['id']}}">
                                            <option value="1"
                                                    @if($comment['status'] == 1) selected @endif
                                            >通过
                                            </option>
                                            <option value="2"
                                                    @if($comment['status'] == 2) selected @endif
                                            >待审核
                                            </option>
                                            <option value="0"
                                                    @if($comment['status'] == 0) selected @endif
                                            >删除
                                            </option>
                                        </select>
                                    </h4>

                                </a>
                            </li>
                            @if(isset($new_child_list[$comment['id']]))
                                <ul>
                                    @foreach($new_child_list[$comment['id']] as $child_c)
                                        @if($child_c)
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <h4>
                                                        {{$child_c['member_name']}}
                                                        <small>回复</small>
                                                        &nbsp;{{$child_c['reply_member_name']}}{{"   ：   "}}
                                                        <span>{{$child_c['content']}}</span>
                                                        <small><i class="fa fa-clock-o"></i>
                                                            时间 : {{$child_c['created_at'] or ''}}{{$child_c['id']}}
                                                        </small>
                                                        <select class="small" name="fa" com_id="{{$child_c['id']}}">
                                                            <option value="1"
                                                                    @if($child_c['status'] == 1) selected @endif
                                                            >通过
                                                            </option>
                                                            <option value="2"
                                                                    @if($child_c['status'] == 2) selected @endif
                                                            >待审核
                                                            </option>
                                                            <option value="0"
                                                                    @if($child_c['status'] == 0) selected @endif
                                                            >删除
                                                            </option>
                                                        </select>
                                                    </h4>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </ul>
                    @endforeach
                </table>

            </div>
            {{$comment_page->appends(request()->all())->render()}}
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

    $('.small').change(function () {
        var com_id = $(this).attr('com_id');
        var status = $(this).val();
        // layer.msg('取消删除', {icon: 1});
        $.ajax({

            type: "get",

            url: "audit-comment",

            data: {com_id: com_id, status: status},

            dataType: "json",

            success: function (data) {
//console.log(data)
                if (data.error_code) {
                    layer.msg('更改失败')
                    return false;
                }
                layer.msg(data.data)
                {{--                window.location.href = '{{env("APP_URL")}}'+'/admin/home'--}}
            },
            error: function () {

            }
        });

    });
</script>
</body>
</html>