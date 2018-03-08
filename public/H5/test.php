<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>经济数据.</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />

    <script src="js/jquery.min.js"></script>
    <script src="js/iscroll.js"></script>
    <link rel="stylesheet" href="css/table_style.css" type="text/css">
    <link href="css/mobiscroll_date.css" rel="stylesheet" />

</head>

<body>


<header>

    <div >
        <form>
        <tr>
            <td width="300">国家</td>
            <td>
                <select name=country><option value=>-- 全部 --<option value=日本>日本<option value=中國>中國<option value=加拿大>加拿大<option value=法國>法國<option value=美國>美國<option value=英國>英國<option value=紐西蘭>紐西蘭<option value=瑞士>瑞士<option value=意大利>意大利<option value=歐元區>歐元區<option value=德國>德國<option value=澳洲>澳洲</option></select>
            </td>
        </tr>
        <tr>
            <td>
                <label>&nbsp;日期：</label>
                <input type="text" name="start_time" id="start_time" readonly class="input" placeholder="选择开始日期" />

                <label>至</label>
                <input type="text" name="end_time" id="end_time" readonly class="input" placeholder="选择结束日期" />
            </td>
        </tr>
            <input type="submit" value="筛选">
        </form>
        <script src="js/jquery.min.js"></script>
        <script src="js/mobiscroll_date.js" charset="gb2312"></script>
        <script src="js/mobiscroll.js"></script>
        <script type="text/javascript">
            $(function () {
                var currYear = (new Date()).getFullYear();
                var opt={};
                opt.date = {preset : 'date'};
                opt.datetime = {preset : 'datetime'};
                opt.time = {preset : 'time'};
                opt.default = {
                    theme: 'android-ics light', //皮肤样式
                    display: 'modal', //显示方式
                    mode: 'scroller', //日期选择模式
                    dateFormat: 'yyyy-mm-dd',
                    lang: 'zh',
                    showNow: true,
                    nowText: "今天",
                    startYear: currYear - 50, //开始年份
                    endYear: currYear + 10 //结束年份
                };

                $("#start_time").mobiscroll($.extend(opt['date'], opt['default']));
                $("#end_time").mobiscroll($.extend(opt['date'], opt['default']));

            });
        </script>
    </div>

</header>
<div id="wrapper">
    <div class="scroller">
        <div id="container">
            <table class="zebra">
                <caption>Beautiful design tables in HTML in the style of a zebra.</caption>
                <thead>
                <tr>
                    <th style="width: 10%">日期</th>
                    <th style="width: 8%">香港时间</th>
                    <th style="width: 8%">国家</th>
                    <th style="width: 36%">经济数据名称</th>
                    <th style="width: 6%">季度</th>
                    <th style="width: 6%">月份</th>
                    <th style="width: 10%">预测</th>
                    <th style="width: 8%">上次</th>
                    <th style="width: 8%" >公布结果</th>
                </tr>
                </thead>
                <tbody id="countent">
                <?php
                $partment='?';
                if(isset($_GET['per_num'])){
                    $partment=$partment.'&per_num='.$_GET['per_num'];
                }
                if(isset($_GET['country'])){
                    $partment=$partment.'&country='.$_GET['country'];
                }
                if(isset($_GET['start_time'])){
                    $partment=$partment.'&start_time='.$_GET['start_time'];
                }
                if(isset($_GET['end_time'])){
                    $partment=$partment.'&end_time='.$_GET['end_time'];
                }

                    $url="http://test.daddyprefer.com/sync/econ_list".$partment;
                    $json_string = file_get_contents($url);
                    $data = json_decode($json_string, true);
                if($data['error_code']!=0) echo("<tr><td>error_code:</td><td>".$data['error_code']."</td></tr>");

                foreach($data['data']['data'] as $value){
                    echo "<tr>";
                    foreach($value as $k=>$v){
                        if($k=='id' or $k=='create_time')continue;
                        if($k=='date')$v=date("y-m-d",$v);
                        echo "<td>$v</td>";
                    }
                    echo"</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="more"><i class="pull_icon"></i><span>上拉加载...</span></div>
    </div>
</div>
<script>
    var myscroll = new iScroll("wrapper",{
        onScrollMove:function(){
            if (this.y<(this.maxScrollY)) {
                $('.pull_icon').addClass('flip');
                $('.pull_icon').removeClass('loading');
                $('.more span').text('释放加载...');
            }else{
                $('.pull_icon').removeClass('flip loading');
                $('.more span').text('上拉加载...')
            }
        },
        onScrollEnd:function(){
            if ($('.pull_icon').hasClass('flip')) {
                $('.pull_icon').addClass('loading');
                $('.more span').text('加载中...');
                pullUpAction();
            }

        },
        onRefresh:function(){
            $('.more').removeClass('flip');
            $('.more span').text('上拉加载...');
        }

    });

    var countPage=2;
    function pullUpAction(){
        setTimeout(function(){
            /*$.ajax({
             url:'/json/ay.json',
             type:'get',
             dataType:'json',
             success:function(data){
             for (var i = 0; i < 5; i++) {
             $('.scroller ul').append(data);
             }
             myscroll.refresh();
             },
             error:function(){
             console.log('error');
             },
             })*/

            function timestampToTime(timestamp) {
                var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
                Y = date.getFullYear() + '-';
                M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
                D = date.getDate() + ' ';
                h = date.getHours() + ':';
                m = date.getMinutes() + ':';
                s = date.getSeconds();
                return Y+M+D;
            }

            var url3 = 'http://test.daddyprefer.com/sync/econ_list?page=' +countPage ;
            $.get(url3,function(data){
               // alert(countPage);
                countPage++;
                //var a;
                //a = new Array(0,1,2,3,4,5,6,7,8);
                for(var i=0;i<data["data"]["data"].length;i++){
                   // a=data["data"]["data"][i];
                   // $('.scroller tbody').append("<tr><td>"+ a.join("</td><td>")  +"</td></tr>");
$('.scroller tbody').append("<tr><td>"+ timestampToTime(data["data"]["data"][i]['date'])  +"</td><td>"+ data["data"]["data"][i]['hktime']  +"</td><td>"+ data["data"]["data"][i]['country']  +"</td><td>"+ data["data"]["data"][i]['fname']  +"</td><td>"+ data["data"]["data"][i]['quarter']  +"</td><td>"+ data["data"]["data"][i]["month"]  +"</td><td>"+ data["data"]["data"][i]['forecast']  +"</td><td>"+ data["data"]["data"][i]['lasttime']  +"</td><td>"+ data["data"]["data"][i]['value']  +"</td></tr>");
                }

            });
            myscroll.refresh();
        }, 1000)
    }
    if ($('.scroller').height()<$('#wrapper').height()) {
        $('.more').hide();
        myscroll.destroy();
    }

</script>
</body>
</html>