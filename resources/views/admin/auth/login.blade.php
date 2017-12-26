

<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{env('COMPANY')}}| {{ env('COMPANY_LANG') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../../js/layer/theme/default/layer.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->
</head>
<body class="bg-black">

<div class="form-box" id="login-box">
    <div class="header">后台管理登录</div>
    <form  method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="username" id="name" class="form-control" placeholder="用户名" required/>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="密码" required/>
            </div>
            <div class="form-group">
                <input type="radio" name="remember_me" id="remember" /> 记住我
            </div>
        </div>
        <div class="footer">
            <button type="button" class="btn bg-olive btn-block" id="submit">登录</button>

            <p><a href="{{env('CUSTOMER_CONTRACT')}}">登录失败？ 联系管理员</a></p>

            <a href="register.html" class="text-center">Register a new membership</a>
        </div>
    </form>

    {{--<div class="margin text-center">--}}
        {{--<span>Sign in using social networks</span>--}}
        {{--<br/>--}}
        {{--<button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>--}}
        {{--<button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>--}}
        {{--<button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>--}}

    {{--</div>--}}
</div>


<!-- jQuery 2.0.2 -->
<script src="Js/jquery.min.js"></script>
<script src="Js/layer/layer.js"></script>
<!-- Bootstrap -->
<script src="Js/js/bootstrap.min.js" type="text/javascript"></script>
<script>


    $('#submit').click(function(){
        var password = $('#password').val();
        var name = $('#name').val();
        var remember = $('#remember').prop('checked');
        if(!name || !password){
            layer.alert('用户名和密码不合法'
               //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
            )
            return false;
        }

        $.ajax({

            type: "POST",

            url: "login",

            data: {name:name, password:password,remember:remember},

            dataType: "json",

            success: function(data){
                console.log(data)
                if(data.error_code){
                    $('#password').val("")
                    $('#name').val("");
                    layer.msg(data.error_message)
                    return false;
                }

                window.location.href = '{{env("APP_URL")}}'+'/admin/home'
            },
            error:function(){

            }
        });
    })


</script>
</body>
</html>