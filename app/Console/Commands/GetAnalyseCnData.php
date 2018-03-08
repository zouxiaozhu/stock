<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class GetAnalyseCnData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_analyse_cn_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get analyse(Chinese) data everyFiveMinutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//     1.倫敦黃金 - http://www.mw801.com/appcn/commentary/commentary-xau.xml
//     2.倫敦白銀 - http://www.mw801.com/appcn/commentary/commentary-xag.xml(xml获取不到)
//     3.歐元    - http://www.mw801.com/appcn/commentary/commentary-eur.xml
//     4.日元    - http://www.mw801.com/appcn/commentary/commentary-jpy.xml
//     5.英鎊    - http://www.mw801.com/appcn/commentary/commentary-gbp.xml
//     6.端郎    - http://www.mw801.com/appcn/commentary/commentary-chf.xml
//     7.澳元    - http://www.mw801.com/appcn/commentary/commentary-aud.xml (✔️)
//     8.紐元    - http://www.mw801.com/appcn/commentary/commentary-nzd.xml (✔)
//     9.加元    - http://www.mw801.com/appcn/commentary/commentary-cad.xml
//     10.港股分析  -- http://www.mw801.com/appcn/commentary/commentary-stocks.xml
//     11.昨日市场总结 --http://www.mw801.com/appcn/commentary/commentary-yesterday.xml
//     12.市场焦距 --http://www.mw801.com/appcn/commentary/commentary-focus.xml


        //1.倫敦黃金
        $url = config('xmlurl.xau');
        $remote_data = xml2arr($url);
//        var_export($remote_data);die;
        $xau_data = $remote_data['commentary'];
        array_walk($xau_data, function(&$val) {
            $val['type'] = 1;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //2.倫敦白銀
        $url = config('xmlurl.xag');
        $remote_data = xml2arr($url);
        $xag_data = $remote_data['commentary'];
        array_walk($xag_data, function(&$val) {
            $val['type'] = 2;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //3.歐元
        $url = config('xmlurl.eur');
        $remote_data = xml2arr($url);
        $eur_data = $remote_data['commentary'];
        array_walk($eur_data, function(&$val) {
            $val['type'] = 3;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //4.日元
        $url = config('xmlurl.jpy');
        $remote_data = xml2arr($url);
        $jpy_data = $remote_data['commentary'];
        array_walk($jpy_data, function(&$val) {
            $val['type'] = 4;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });
        //5.英鎊
//        $url = config('xmlurl.gbp');
//        $remote_data = xml2arr($url);
//        $gbp_data = $remote_data['commentary'];
//        array_walk($gbp_data, function(&$val) {
//            $val['type'] = 5;
//            $val['lang'] = 1;   //1=>中文,2=>英文
//        });

        //6.端郎
        $url = config('xmlurl.chf');
        $remote_data = xml2arr($url);
        $chf_data = $remote_data['commentary'];
        array_walk($chf_data, function(&$val) {
            $val['type'] = 6;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //7.澳元
        $url = config('xmlurl.aud');
        $remote_data = xml2arr($url);
        $aud_data = $remote_data['commentary'];
        array_walk($aud_data, function(&$val) {
            $val['type'] = 7;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //8.紐元
        $url = config('xmlurl.nzd');
        $remote_data = xml2arr($url);
        $nzd_data = $remote_data['commentary'];
        array_walk($nzd_data , function(&$val) {
            $val['type'] = 8;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //9.加元
        $url = config('xmlurl.cad');
        $remote_data = xml2arr($url);
        $cad_data = $remote_data['commentary'];
        array_walk($cad_data , function(&$val) {
            $val['type'] = 9;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //10.港股分析
        $url = config('xmlurl.stock');
        $remote_data = xml2arr($url);
        $stock_data = $remote_data['commentary'];
        array_walk($stock_data , function(&$val) {
            $val['type'] = 10;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //11.昨日总结
        $url = config('xmlurl.yesterday');
        $remote_data = xml2arr($url);
        $yes_data = $remote_data['commentary'];
        array_walk($yes_data , function(&$val) {
            $val['type'] = 11;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

        //12.市场焦距
        $url = config('xmlurl.focus');
        $remote_data = xml2arr($url);
        $focus_data = $remote_data['commentary'];
        array_walk($focus_data , function(&$val) {
            $val['type'] = 12;
            $val['lang'] = 1;   //1=>中文,2=>英文
        });

//        $data = array_merge($xau_data, $xag_data, $eur_data, $jpy_data, $gbp_data, $chf_data, $aud_data, $nzd_data, $cad_data, $stock_data, $yes_data, $focus_data);
        $data = array_merge($xau_data, $xag_data, $eur_data, $jpy_data, $chf_data, $aud_data, $nzd_data, $cad_data, $stock_data, $yes_data, $focus_data);
        $this->_syncData($data);
        return true;
    }


    private function _syncData($data)
    {
        if (empty($data)) return true;
        foreach ($data as $k => $v) {
            $update_data = [
                $v['id'],
                strtotime($v['date']),
                serialize($v['title']),
                $v['type'],
                $v['content'],
                time(),
                $v['lang']
            ];
            DB::insert('replace into stock_analy values(?,?,?,?,?,?,?)', $update_data);
        }
        return true;
    }

}
