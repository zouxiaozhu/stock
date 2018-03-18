<?php
namespace App\Http\Controllers\Backend;
use App\Http\Models\Backend\JinShuModel;
use App\Http\Models\Backend\WaihuiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Chart extends \App\Http\Controllers\Controller{


    public function __construct()
    {

    }

    public function chart()
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        $waihui_chart = WaihuiModel::where('id','>',0)->get()->toArray();
        $jinshu_chart = JinShuModel::where('id','>',0)->get()->toArray();


        return view('admin.chart.edit-chart',['waihui'=>$waihui_chart,'jinshu'=>$jinshu_chart])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function editJinshuChart(Request $request)
    {
        $year = $request->get('year',0);
        $jinshu_chart = JinShuModel::where('id','>',0)->where('year',$year)->get()->toArray();
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
       
        if($request->isMethod('get')){
            return view('admin.chart.edit-jinshu',['jinshu'=>array_column($jinshu_chart,null,'key'),'year'=>$year])
                ->with(['prms' => $prms, 'roles_info' => $role]);
        }


        $insert_key =['llg','lls','hkg','plat','lgls','lenu','lgjp','lggp','lgau'];
            $chinese_key = ['伦敦金(LLG)','伦敦银(LLS)','港金(HKG)','白金(PLAT)'
            ,'黄金白银(LGLS)','黄金欧元(LGEU)','黄金日圆(LGJP)','黄金英镑(LGGP)','黄金澳元(LGAU)'];
        $insert = [];

        foreach ($insert_key as $key=>$item){

            $insert_tmp = [
                'name'=>$chinese_key[$key]?:'',
                'key'=>$item,
                'day'=>$request->get($item.'_day')?:'',
                'week'=>$request->get($item.'_week')?:'',
                'month'=>$request->get($item.'_month')?:'',
                'now_top'=>$request->get($item.'_now_top')?:0,
                'now_bottom'=>$request->get($item.'_now_bottom')?:0,
                'top'=>$request->get($item.'_top')?:0,
                'bottom'=>$request->get($item.'_bottom')?:0,
                'year'=>$year,
            ];
//            var_export();die;
            $insert[] = $insert_tmp;
        }
        DB::table('jinshu_chart')->where('year',$year)->delete();

        DB::table('jinshu_chart')->insert($insert);
//        var_export($insert);die;
        $jinshu_chart = JinShuModel::where('id','>',0)->where('year',$year)->get()->toArray();
        return view('admin.chart.edit-jinshu',['jinshu'=>array_column($jinshu_chart,null,'key'),'year'=>$year])
            ->with(['prms' => $prms, 'roles_info' => $role]);

    }

    // 外汇
    public function editWaihuiChart(Request $request)
    {

        $year = $request->get('year',0);
        $waihui = WaihuiModel::where('id','>',0)->where('year',$year)->get()->toArray();
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
//var_export(array_column($waihui,null,'key'));die;
        if($request->isMethod('get')){
            return view('admin.chart.edit-waihui',['waihui'=>array_column($waihui,null,'key'),'year'=>$year])
                ->with(['prms' => $prms, 'roles_info' => $role]);
        }

        $insert_key =['eur','jpy','gbp','chf','aud','nzd','cad','usd','cnh'];
        $chinese_key = ['欧元(EUR)','日元(JPY)','英镑(GBP)','瑞郎(CHF)'
            ,'澳元(AUD)','纽元(NZD)','加元(CAD)','美元(USD)','人民币(CNH)'];
        $insert = [];

        foreach ($insert_key as $key=>$item){

            $insert_tmp = [
                'key'=>$item,
                'name'=>$chinese_key[$key]?:'',
                'day'=>$request->get($item.'_day')?:'',
                'week'=>$request->get($item.'_week')?:'',
                'month'=>$request->get($item.'_month')?:'',
                'now_top'=>$request->get($item.'_now_top')?:0,
                'now_bottom'=>$request->get($item.'_now_bottom')?:0,
                'top'=>$request->get($item.'_top')?:0,
                'bottom'=>$request->get($item.'_bottom')?:0,
                'year'=>$year
            ];
            $insert[] = $insert_tmp;

            DB::table('waihui_chart')->where('year',$year)->delete();
            DB::table('waihui_chart')->insert($insert);
        }

        $waihui = WaihuiModel::where('id','>',0)->where('year',$year)->get()->toArray();
        return view('admin.chart.edit-waihui',['waihui'=>array_column($waihui,null,'key'),'year'=>$year])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }



    // 外汇
    public function editJiaoChaPanChart(Request $request)
    {
        $year = $request->get('year',0);
        $jiaochapan = DB::table('jiaochapan_chart')->where('id','>',0)->where('year',$year)->get();
        $jiaochapan = obj2Arr($jiaochapan);

        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
//var_export(array_column($waihui,null,'key'));die;
        if($request->isMethod('get')){
            return view('admin.chart.edit-jiaochapan',['jiaochapan'=>array_column($jiaochapan,null,'key'),'year'=>$year])
                ->with(['prms' => $prms, 'roles_info' => $role]);
        }

        $insert_key =['eujp','eucf','eugp','gpjp','cfjp','aujp','aunz'];
        $chinese_key = ['歐元日圓(EUJP)','歐元瑞郎(EUCF) ','歐元英鎊(EUGP)','英鎊日圓(GPJP'
            ,'瑞郎日圓(CFJP) ','澳元日圓(AUJP)','澳元紐元(AUNZ)'];
        $insert = [];

        foreach ($insert_key as $key=>$item){

            $insert_tmp = [
                'key'=>$item,
                'name'=>$chinese_key[$key]?:'',
                'day'=>$request->get($item.'_day')?:'',
                'week'=>$request->get($item.'_week')?:'',
                'month'=>$request->get($item.'_month')?:'',
                'now_top'=>$request->get($item.'_now_top')?:0,
                'now_bottom'=>$request->get($item.'_now_bottom')?:0,
                'top'=>$request->get($item.'_top')?:0,
                'bottom'=>$request->get($item.'_bottom')?:0,
                'year'=>$year
            ];
            $insert[] = $insert_tmp;

            DB::table('jiaochapan_chart')->where('year',$year)->delete();
            DB::table('jiaochapan_chart')->insert($insert);
        }

        $jiaochapan = DB::table('jiaochapan_chart')->where('year',$year)->where('id','>',0)->get();
        $jiaochapan = obj2Arr($jiaochapan);
        return view('admin.chart.edit-jiaochapan',['jiaochapan'=>array_column($jiaochapan,null,'key'),'year'=>$year])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function editQiHuoChart(Request $request)
    {
        $year = $request->get('year',0);
        $qihuo = DB::table('qihuo_chart')->where('year',$year)->where('id','>',0)->get();
        $qihuo = obj2Arr($qihuo);
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
//var_export(array_column($waihui,null,'key'));die;
        if($request->isMethod('get')){
            return view('admin.chart.edit-qihuo',['qihuo'=>array_column($qihuo,null,'key'),'year'=>$year])
                ->with(['prms' => $prms, 'roles_info' => $role]);
        }

        $insert_key =['oil','copper','crb','hsi','sseci','dow','spx','ndx'];
        $chinese_key = ['原油(OIL)','銅(COPPER)','商品期貨指數(CRB)','恒生指數(HSI)'
            ,'上海綜合指數SSECI)','道瓊斯指數(DOW)','標準普爾(SPX)','納斯達克(NDX)'];
        $insert = [];

        foreach ($insert_key as $key=>$item){

            $insert_tmp = [
                'key'=>$item,
                'name'=>$chinese_key[$key]?:'',
                'day'=>$request->get($item.'_day')?:'',
                'week'=>$request->get($item.'_week')?:'',
                'month'=>$request->get($item.'_month')?:'',
                'now_top'=>$request->get($item.'_now_top')?:0,
                'now_bottom'=>$request->get($item.'_now_bottom')?:0,
                'top'=>$request->get($item.'_top')?:0,
                'bottom'=>$request->get($item.'_bottom')?:0,
                'year'=>$year

            ];
            $insert[] = $insert_tmp;

            DB::table('qihuo_chart')->where('year',$year)->delete();
            DB::table('qihuo_chart')->insert($insert);
        }

        $qihuo = DB::table('qihuo_chart')->where('year',$year)->where('id','>',0)->get();
        $qihuo = obj2Arr($qihuo);
        return view('admin.chart.edit-qihuo',['qihuo'=>array_column($qihuo,null,'key'),'year'=>$year])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }









}