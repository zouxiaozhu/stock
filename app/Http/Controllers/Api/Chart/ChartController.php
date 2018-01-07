<?php
namespace App\Http\Controllers\Api\Chart;


use App\Http\Controllers\ApiAuth\ApiAuthTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
class ChartController extends  Controller{

    use ApiAuthTrait;
    public function __construct(Request $request)
    {
        if(!$request->get('access_token')){
           $this->res_error('缺少access_token');
        }
        $res = $this->decode_access_token($request->get('access_token'));
        if(!$res){
            $this->res_error('登录信息过期');
        }
    }

    /**
     * 获取图表
     * @param Request $request
     */
    public function getChart(Request $request)
    {
        $pro_type = ['qihuo','guijinshu','jiaochapan','waihui'];
        $type = $request->get('type');
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

        $res = DB::table($table)->get();
        $res = obj2Arr($res);

        $res = array_map(function($value){
            $value['day'] = explode(',',$value['day']);
            $value['week'] = explode(',',$value['week']);
            $value['month'] = explode(',',$value['month']);
            return $value;
        },$res);
        return $this->res_true([$type=>$res]);
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