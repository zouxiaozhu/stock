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
                                    <li><a href="{{env('APP_URL')}}/admin/index-file"><i class="fa fa-angle-double-right"></i>文件列表</a></li>@else
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
               <!--- //   //下载类型:1=>英皇金业,2=>英皇证券,3=>英皇期货-->

                <button><a href="{{env("APP_URL")}}/admin/index-download?type=1">英皇金业</a></button>
                <button><a href="{{env("APP_URL")}}/admin/index-download?type=2">英皇证券</a></button>
                <button><a href="{{env("APP_URL")}}/admin/index-download?type=3">英皇期货</a></button>
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
                                <table class="table table-hover">
                                    <tr>
                                        <th>编号</th>
                                        <th>
                                            名称
                                        </th>
                                        <th>jpg地址</th>
                                        <th>pdf地址</th>
                                        <th>编辑</th>
                                        <th>删除</th>
                                    </tr>

                                    @foreach($download_list as $key=>$download)
                                        <tr>
                                            <td>{{$download['id']}}</td>
                                            <td>
                                        <span class="label label-success">
                                            {{$download['table_name']}}
                                        </span>
                                            </td>
                                            <td>{{$download['pdf_url']}}</td>
                                            <td>{{$download['jpg_url']}}</td>

                                            <td><a href="{{env("APP_URL")}}/admin/edit-download?id={{$download['id']}}">编辑</a></td>
                                            <td><a href="{{env("APP_URL")}}/admin/delete-download?id={{$download['id']}}">删除</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>

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