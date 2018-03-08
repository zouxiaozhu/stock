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
                    <select name=country>
                        <?php
                        function country($c){
                            switch ($c){
                                case 1 : return '日本';break;
                                case 2 : return '中國';break;
                                case 3 : return '加拿大';break;
                                case 4 : return '法國';break;
                                case 5 : return '美國';break;
                                case 6 : return '英國';break;
                                case 7 : return '紐西蘭';break;
                                case 8 : return '瑞士';break;
                                case 9 : return '意大利';break;
                                case 10 : return '歐元區';break;
                                case 11 : return '德國';break;
                                case 12 : return '澳洲';break;
                                default: return '';break;

                            }
                        }
                        if(isset($_GET['country'])){
                            if($_GET['country']>12 ||$_GET['country']<1);
                            else echo '<option value='.$_GET['country'].'>'.country($_GET['country']);
                        }
                        ?>
                        <option value=>-- 全部 --<option value=1>日本<option value=2>中國<option value=3>加拿大<option value=4>法國<option value=5>美國<option value=6>英國<option value=7>紐西蘭<option value=8>瑞士<option value=9>意大利<option value=10>歐元區<option value=11>德國<option value=12>澳洲</option></select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>&nbsp;日期：</label>
                    <input type="text" name="start_time" id="start_time" readonly class="input" placeholder="选择开始日期" <?php
                    if(isset($_GET['start_time'])&&$_GET['start_time']!='')echo 'value="'.$_GET['start_time'].'"';
                    ?>/>

                    <label>至</label>
                    <input type="text" name="end_time" id="end_time" readonly class="input" placeholder="选择结束日期" <?php
                    if(isset($_GET['end_time'])&&$_GET['end_time']!='')echo 'value="'.$_GET['end_time'].'"';
                    ?>/>
                </td>
            </tr>
            <input type="submit" value="筛选">
        </form>
        <script src="js/jquery.min.js"></script>
        <script src="js/mobiscroll_date.js" charset="gb2312"></script>
        <script src="js/mobiscroll.js"></script>
        <script type="text/javascript">//下拉日期JS
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
                $parameter='?';
                if(isset($_GET['per_num'])){
                    $parameter=$parameter.'&per_num='.$_GET['per_num'];
                }
                if(isset($_GET['country'])&& $_GET['country']!=''){
                    $parameter=$parameter.'&country='.country($_GET['country']);
                }
                if(isset($_GET['start_time'])&& $_GET['start_time']!=''){
                    $parameter=$parameter.'&start_time='.(strtotime($_GET['start_time'])-1);
                }
                if(isset($_GET['end_time'])&& $_GET['end_time']!=''){
                    $parameter=$parameter.'&end_time='.(strtotime($_GET['end_time'])+1);
                }

                $url="http://test.daddyprefer.com/sync/econ_list".$parameter;
                $json_string = file_get_contents($url);
                $data = json_decode($json_string, true);
                if($data['error_code']!=0) die("<tr><td>error_code:</td><td>".$data['error_code']."</td><td></td><td>返回或者重新筛选</td><td></td><td></td><td></td><td></td><td></td></tr>");

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
<script>//上拉加载JS
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

            function timestampToTime(timestamp) {
                var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
                Y = (date.getFullYear()-2000) + '-';
                M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
                D = date.getDate() < 10 ?  '0'+date.getDate()  : date.getDate()  + ' ';
                h = date.getHours() + ':';
                m = date.getMinutes() + ':';
                s = date.getSeconds();
                return Y+M+D;
            }

            function GetRequest() {
                var url = location.search; //获取url中"?"符后的字串
                var theRequest = new Object();
                if (url.indexOf("?") != -1) {
                    var str = url.substr(1);
                    strs = str.split("&");
                    for(var i = 0; i < strs.length; i ++) {
                        theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
                    }
                }
                return theRequest;
            }
            var qs =GetRequest();
            //处理URL传参
            var qsc ;
            var qss=new Date(qs['start_time']);
            var qse=new Date(qs['end_time']);
            switch (qs['country']){
                case '1' :  qsc='日本';break;
                case '2' :  qsc= '中國';break;
                case '3' :  qsc= '加拿大';break;
                case '4' :  qsc= '法國';break;
                case '5' :  qsc= '美國';break;
                case '6' :  qsc= '英國';break;
                case '7' :  qsc= '紐西蘭';break;
                case '8' :  qsc= '瑞士';break;
                case '9' :  qsc= '意大利';break;
                case '10' : qsc= '歐元區';break;
                case '11' : qsc= '德國';break;
                case '12' : qsc= '澳洲';break;
                default: qsc='';break;

            }
            // alert(qsc + qs['country']);
            //alert(qss.valueOf()/1000-1);
            // alert(qse.valueOf()/1000+1);
            //拼接参数
            var parameter='?';
            if(qsc!='')parameter=parameter + 'country=' + qsc + '&';
            if(!isNaN(qss)){
                parameter=parameter + 'start_time=' + (qss.valueOf()/1000-1) + '&';
            }
            if(!isNaN(qse)){
                parameter=parameter + 'end_time=' + (qse.valueOf()/1000+1) + '&';
            }
            parameter=parameter + 'page=';
            var url3 = 'http://test.daddyprefer.com/sync/econ_list'+ parameter +countPage ;

            alert(url3);
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
                myscroll.refresh();
            });



        }, 1000)
    }
    /*  if ($('.scroller').height()<$('#wrapper').height()) {
     $('.more').hide();
     myscroll.destroy();
     }
     */
</script>
</body>
</html>