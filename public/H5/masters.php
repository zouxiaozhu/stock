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
$json_string = file_get_contents( "http://test.daddyprefer.com/sync/ace_detail/$id");
$data = json_decode($json_string, true);
//var_dump($data);
foreach($data['data'] as $k=>$v){
    $$k=$v;
}

                function products($product_type){
                    switch($product_type){
                        case "a1": return "LLG/黃金"; break;
                        case "a2": return "LLS/白銀"; break;
                        case "a3": return "EUR/歐元"; break;
                        case "a4": return "JPY/日圓"; break;
                        case "a5": return "GBP/英鎊"; break;
                        case "a6": return "CHF/瑞郎"; break;
                        case "a7": return "AUD/澳元"; break;
                        case "a8": return "NZD/紐元"; break;
                        case "a9": return "CAD/加元"; break;
                        case "b1": return "恒生指數期貨"; break;
                        case "b2": return "Ｈ股指數期貨"; break;
                        case "b3": return "美元兌人民幣(香港)期貨"; break;
                        case "b4": return "原油"; break;
                        case "b5": return "無鉛汽油"; break;
                        case "b6": return "民用燃料油"; break;
                        case "b7": return "天然氣"; break;
                        case "b8": return "銅"; break;
                        case "b9": return "白金"; break;
                        case "b10": return "鈀"; break;
                        case "b11": return "杜瓊斯工業指數"; break;
                        case "b12": return "玉米"; break;
                        case "b13": return "大豆"; break;
                        case "b14": return "大豆粕"; break;
                        case "b15": return "大豆油"; break;
                        case "b16": return "小麥"; break;
                        case "b17": return "大麥"; break;
                        case "b18": return "標準普爾500指數"; break;
                        case "b19": return "納斯達克指數"; break;
                        case "b20": return "日經225指數"; break;
                        case "b21": return "棉花"; break;
                        case "b22": return "咖啡"; break;
                        case "b23": return "第11類糖"; break;
                        case "b24": return "橙汁"; break;
                        case "b25": return "美匯指數"; break;
                        case "b26": return "布蘭特原油"; break;
                        case "b27": return "鋅"; break;
                        case "b28": return "錫"; break;
                        case "b29": return "鉛"; break;
                        case "b30": return "鎳"; break;
                        case "c1": return "香港"; break;
                        case "c2": return "美國"; break;
                        case "c3": return "中國"; break;


                    }
                }
            ?>
<html lang="en">
<head>
    <meta name="renderer" content="webkit">
    <meta charset="gbk">
    <title><?php echo $create_user_name."的".products($product_type)."点评";?></title>
    <meta name="keywords" content="<?php echo $create_user_name."的".products($product_type)."点评";?>" />
    <meta name="description" content="<?php echo  $create_user_name."的".products($product_type)."点评";?>" />
    <meta name="author" content="371" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">

    <script src="include/jquery-1.7.1.min.js" language="JavaScript" ></script>

    <link type="text/css" rel="stylesheet" href="css/show.css??ver1" />

    <script type="text/javascript" src="js/wap/new_wap_public.js?ver1"></script>
    <script type="text/javascript" src="js/wap/wapShare.js?ver1"></script>

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
            <div style="float: left; margin:10px;"><img  style="margin: 0 5px " width="16" src="<?php echo $avatar;?>" ><?php echo $create_user_name ;?></div>
            <div style="float: right; margin:10px;">发布时间:<?php echo date("Y-m-d H:i:s",$create_time) ;?></div>
        </div>
    </div>		<div class="news_conter padding_b">
        <div class="news_imgText newsList">
            <div class="news_text" >
                <p><p style="line-height: 1.75em;">产品：<?php echo products($product_type);?></p> </p>
                <p><p style="line-height: 1.75em;">价格：<?php echo $from_price.'-'.$to_price;?></p> </p>
                <p><p style="line-height: 1.75em;">日期：<?php echo date('Y-m-d',$date);?></p> </p>
                <p><p style="line-height: 1.75em;">时间：<?php echo $time;?></p> </p>
                <p><p style="line-height: 1.75em;">止损：<?php echo $stop_loss;?></p> </p>
                <p><p style="line-height: 1.75em;">目标：<?php echo $target;?></p> </p>
                <p><p style="line-height: 1.75em;">点评：<?php echo $comment;?></p> </p>
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