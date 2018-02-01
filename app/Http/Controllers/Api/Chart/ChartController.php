<?php
namespace App\Http\Controllers\Api\Chart;


use App\Http\Controllers\ApiAuth\ApiAuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\TerminalSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
class ChartController extends  Controller{

    use ApiAuthTrait;
    public function __construct(Request $request)
    {

    }
    /**
     * 获取图表
     * @param Request $request
     */
    public function getChart(Request $request)
    {
        $year = $request->get('year',0);
        $pro_type = ['qihuo','guijinshu','jiaochapan','waihui'];
        $type = $request->get('type', 'guijinshu');
        if(!in_array($type,$pro_type)){
            return $this->res_error('不合法的类型');
        }
        switch ($type){
            case 'qihuo':
                $table = 'qihuo_chart';
                break;
            case 'guijinshu':
                $table = 'jinshu_chart';
                break;
            case 'jiaochapan':
                $table = 'jiaochapan_chart';
                break;
            case 'waihui':
                $table = 'waihui_chart';
                break;
        }

        $res = DB::table($table)
            ->select('name', 'now_top', 'now_bottom', 'top', 'bottom')
            ->where('year',$year)->get();
        $res = obj2Arr($res);
        if(!$res){
            return $this->res_true([$type=>[]]);
        }
        $res = array_map(function($value){
            $value['day'] = explode(',',$value['day']);
            $value['week'] = explode(',',$value['week']);
            $value['month'] = explode(',',$value['month']);
            return $value;
        },$res);
        return $this->res_true([$type=>$res]);
    }


    public function setting()
    {
        $download = TerminalSettings::whereIn('key',['jpg','pdf'])->get()->toArray();
        $download = array_column($download, null, 'key');
        $this->res_true($download);
    }

    public function res_true($data = '')
    {
        echo json_encode(['error_code'=>0,'data'=>$data]);die;
    }

    public function res_error($msg='',$code=400,$status=false)
    {
        echo json_encode(['error_code'=>$code,
            'status'=>$status,
        'error_message'=>$msg,
        ]);die;
    }
}