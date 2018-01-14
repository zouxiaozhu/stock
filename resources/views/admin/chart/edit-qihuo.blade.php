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
                    <img src="{{session()->get('user_info')['avatar'] OR ''}}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>Hello,{{session()->get('user_info')['name']  OR ''}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
        {{--<div class="input-group">--}}
        {{--<input type="text" name="q" class="form-control" placeholder="Search..."/>--}}
        {{--<span class="input-group-btn">--}}
        {{--<button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
        {{--</span>--}}
        {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                {{--<li class="active">--}}
                {{--<a href="index.html">--}}
                {{--<i class="fa fa-dashboard"></i> <span>权限管理</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                <?php if (!$prms) {
                    $prms = [];
                }?>
                @foreach($prms as $k=>$prm)
                    @if($prm['name'])

                        <li class="treeview {{$prm['prm']=='chart'?'active':''}}">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>{{$prm['name']}}</span>
                                @if($prm['prm'] != 'chart')
                                    <i class="fa fa-angle-left pull-right"></i>
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
                                @else
                                    <li><a href="{{env('APP_URL')}}/admin/index-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> {{$prm['name']}}列表</a>
                                    <li><a href="{{env('APP_URL')}}/admin/edit-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 新增{{$prm['name']}}</a>
                                    </li>
                                @endif

                                {{--<li><a href="{{env('APP_URL')}}/admin/edit-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 编辑{{$prm['name']}}</a></li>--}}
                                {{--<li ><a href="{{env('APP_URL')}}/admin/del-{{$prm['prm']}}"><i class="fa fa-angle-double-right"></i> 删除{{$prm['name']}}</a></li>--}}
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
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">期货</li>
            </ol>
        </section>

        <?php
        $insert_key =['oil','copper','crb','hsi','sseci','dow','spx','ndx'];
        $chinese_key = ['原油(OIL)','銅(COPPER)','商品期貨指數(CRB)','恒生指數(HSI)'
            ,'上海綜合指數SSECI)','道瓊斯指數(DOW)','標準普爾(SPX)','納斯達克(NDX)'];
        ?>
        <section>
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">
                           期货
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" action="edit-qihuo-chart" method="post">
                            <div class="form-inline">
                                <label>年份</label>
                                <select name="year" id="year">
                                    <option value="0" @if($year==0)
                                    selected
                                            @endif
                                    >--请选择年份--</option>
                                    @for($i=1990;$i<=2030;$i++)
                                        <option value="{{$i}}"
                                                @if($year==$i)
                                                selected
                                                @endif
                                        >{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            @foreach($insert_key as $j_k =>$item)
                                <div class="box-footer text-center">
                                    <button type="" class="btn btn-info">{{$chinese_key[$j_k]}}</button>
                                </div>
                                <div class="form-inline">
                                    <label>
                                        日（阳图 线图 , 隔开）
                                    </label>
                                    <input type="text" class="form-control" name="{{$item}}_day" placeholder="Enter ... 阳图 线图 , 隔开 "
                                           value="{{isset($qihuo[$item]['day'])? $qihuo[$item]['day']  :'' }}" />
                                </div>
                                <div class="form-inline">
                                    <label>周（阳图 线图 , 隔开）</label>
                                    <input type="text" class="form-control" name="{{$item}}_week" placeholder="Enter ... 阳图 线图, 隔开 "
                                           value="{{isset($qihuo[$item]['week']) ? $qihuo[$item]['week'] : '' }} "   />
                                </div>
                                <!-- textarea -->

                                <div class="form-inline">
                                    <label>月<span>阳图 线图 - <隔开></隔开>）</span></label>
                                    <input type="text" class="form-control" placeholder="Enter ...阳图 线图 , 隔开" name="{{$item}}_month" value="{{isset($qihuo[$item]['month']) ? $qihuo[$item]['month'] : ''}} " >
                                </div>
                                <div class="form-inline">
                                    <label>高位</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="{{$item}}_now_top" value="{{ isset($qihuo[$item]['now_top']) ? $qihuo[$item]['now_top'] : 0 }}" >
                                </div>

                                <div class="form-inline">
                                    <label>低位</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="{{$item}}_now_bottom"  value="{{ isset($qihuo[$item]['now_bottom']) ? $qihuo[$item]['now_bottom'] : 0 }}">
                                </div>

                                <div class="form-inline">
                                    <label>历年高位</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="{{$item}}_top"  value="{{$qihuo[$item]['top'] }}">
                                </div>

                                <div class="form-inline">
                                    <label>历年低位</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="{{$item}}_bottom" value="{{ isset($qihuo[$item]['bottom']) ? : 0 }}">
                                </div>
                            @endforeach
                            <div class="box-footer text-center">
                                <button type="submit" class="btn btn-info">提交</button>
                            </div>

                        </form>
                    </div><!-- /.box-body -->
                </div>

            </div><!--/.col (right) -->
            <!-- /.row -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- jQuery 2.0.2 -->
<script src="/Js/jquery.min.js"></script>
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

</body>
</html>

<script>
    $('#year').change(function(){
        var year = $(this).val();
        window.location.href = '{{env("APP_URL")}}'+'/admin/edit-waihui-chart?year='+year

    })
</script>
