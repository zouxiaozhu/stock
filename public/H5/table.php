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
<div style="width:600px; margin:0 auto; height:100px;">
<form action="">
                <select name=country_sel><option value=>-- 全部 --<option value=日本>日本</option><option value=中國>中國</option><option value=加拿大>加拿大</option><option value=法國>法國</option><option value=美國>美國<option value=英國>英國</option><option value=紐西蘭>紐西蘭</option><option value=瑞士>瑞士</option><option value=意大利>意大利</option><option value=歐元區>歐元區</option><option value=德國>德國</option><option value=澳洲>澳洲</option></select>

                <label>开始日期：</label>
      <input type="text" name="USER_AGE" id="USER_AGE" readonly class="input" placeholder="请填写你的开始日期" />
      
      <br>
      <label>结束日期：</label>
      <input type="text" name="USER_AGE2" id="USER_AGE2" readonly class="input" placeholder="请填写你的结束日期" />

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

	$("#USER_AGE").mobiscroll($.extend(opt['date'], opt['default']));
	$("#USER_AGE2").mobiscroll($.extend(opt['date'], opt['default']));

});
</script>
</form>
</div>
</header>
	<div id="wrapper">
		<div class="scroller">
<div id="container"> 
			<table class="zebra">
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
        <tbody>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>123123213213213213</td>
            <td>AAAAAAAAAAAAAA</td>
            <td>222222222222222220</td>
            <td>33333333333333</td>
            <td>44444444444444444444444</td>
            <td>55555555555555555</td>
            <td>666666666666666</td>
            <td>677777777777777777777777</td>
            <td>888888</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
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
				for (var i = 0; i < 5; i++) {
					$('.scroller ul').append("<li>一只将死之猿!</li>");
				}
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