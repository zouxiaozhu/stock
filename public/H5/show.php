<!DOCTYPE html>
<?php
    function findNum($str=''){
        $str=trim($str);
        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0');
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(in_array($str[$i],$temp)){
                $result.=$str[$i];
            }
        }
        return $result;
    }
    $id=findNum($_GET['id']);
    $json_string = file_get_contents( "http://test.daddyprefer.com/sync/news_detail/$id");
    $data = json_decode($json_string, true);
    //var_dump($data);
    foreach($data['data'] as $k=>$v){
         $$k=$v;
    }
?>
<html lang="en">
<head>
    <meta name="renderer" content="webkit">
    <meta charset="gbk">
    <title><?php echo $content;?></title>
    <meta name="keywords" content="<?php echo $content;?>" />
    <meta name="description" content="<?php echo $content;?>" />
    <meta name="author" content="371" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <link type="text/css" rel="stylesheet" href="css/base.css" />
    <script src="include/jquery-1.7.1.min.js" language="JavaScript" ></script>
    <link type="text/css" rel="stylesheet" href="css/web_frame.css??ver1" />

    <!--change_top_tpl-->
    <link type="text/css" rel="stylesheet" href="css/index.css?ver1" >
    <!-- <link type="text/css" rel="stylesheet" href="/css/wap/classStyle.css?ver1" > -->
    <script type="text/javascript" src="js/wap/new_wap_public.js?ver1"></script>
    <script type="text/javascript" src="js/wap/wapShare.js?ver1"></script>



    <link rel="stylesheet" type="text/css" href="css/columnStyle.css">

    <script>
        $(function(){
            var pic_w = $(".news_imgList .imgList .pic").width();
            $(".news_imgList .imgList .pic").css({"height":pic_w+'px',"line-height":pic_w-4+'px'});

            $(".sc_icon, .sc_btn").click(function(){
                if (0) {
                    if($(".sc_icon, .sc_btn").hasClass("cur")){
                        $(".sc_icon, .sc_btn").removeClass("cur");
                    }else{
                        $(".sc_icon, .sc_btn").addClass("cur");
                    }
                }
            })
            // 下拉菜单
            $(".divSelect").each(function(){
                var divSelect = $(this);
                $(this).find(".selectObj").on("change",function(){
                    var v = $(this).val();
                    divSelect.find("span").html(v);
                })
            });

            // 复选框
            $(".divBox .setList").each(function(){
                $(this).click(function(){
                    if($(this).hasClass("cur")){
                        $(this).removeClass("cur");
                    }else{
                        $(this).addClass("cur");
                    }
                })
            });
            // 单选框
            $(".divRadio .setList").each(function(){
                $(this).click(function(){
                    $(this).addClass("cur").siblings().removeClass("cur");
                })
            });
            // 返回顶部
            $(".up_icon").click(function(){
                $('body,html').animate({scrollTop:"0"});
            });

            $(window).scroll(function () {
                var scrollValue = $(window).scrollTop();
                scrollValue > 200 ? $('.up_icon').fadeIn() : $('.up_icon').fadeOut();
            });
        });
    </script>
</head>
<body>
<div class="main" id="wrapper">
    <div class="columnTit">
        <div class="mainTit">
        <div style="float: right; margin:10px;">发布时间:<?php echo date("Y-m-d H:i:s",$publish_date_time) ;?></div>
        </div>
    </div>		<div class="news_conter padding_b">
        <div class="news_imgText newsList">
           <!--
            <h2 class="news_tit"><?php echo $title;?></h2>
            -->
            <div class="news_text" >
                <p><p style="line-height: 1.75em;"><?php echo $content;?></p> </p>
            </div>

            <div class="ev_footer">
                <div class="footer_center">

                    <div class="footer_altImg">
                        <ul>
                            <li>
                                <a href="###" class="up_icon" ></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <center></center>


        <!--文章详细页不显示底部-->
        <span class="backTop" id="back_top"><em></em></span>



    </div>




    <script type="text/javascript">
        var wow_ = new WOW({
            boxClass: 'customModule',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true
        });
        wow_.init();
    </script>
</div>
<div style="height: 10000px;"></div>
</body>
</html>