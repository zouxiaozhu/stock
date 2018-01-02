<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetAnalyseEnData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_analyse_en_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get analyse(English) data everyFiveMinutes';

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
//     1.倫敦黃金 - http://www.mw801.com/appcn/commentary/commentary-xau-eng.xml
//     2.倫敦白銀 - http://www.mw801.com/appcn/commentary/commentary-xag-eng.xml(xml获取不到)
//     3.歐元    - http://www.mw801.com/appcn/commentary/commentary-eur-eng.xml
//     4.日元    - http://www.mw801.com/appcn/commentary/commentary-jpy-eng.xml
//     5.英鎊    - http://www.mw801.com/appcn/commentary/commentary-gbp-eng.xml
//     6.端郎    - http://www.mw801.com/appcn/commentary/commentary-chf-eng.xml
//     7.澳元    - http://www.mw801.com/appcn/commentary/commentary-aud-eng.xml (✔️)
//     8.紐元    - http://www.mw801.com/appcn/commentary/commentary-nzd-eng.xml (✔)
//     9.加元    - http://www.mw801.com/appcn/commentary/commentary-cad-eng.xml

        //1.倫敦黃金
        $url = config('xmlurl.xau-eng');
        $remote_data = xml2arr($url);
        $xau_data = $remote_data['commentary'];
        array_walk($xau_data, function(&$val) {
            $val['type'] = 1;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //2.倫敦白銀
//        $url = config('xmlurl.xag-eng');
//        $remote_data = xml2arr($url);
//        $xag_data = $remote_data['commentary'];
//        array_walk($xag_data, function(&$val) {
//            $val['type'] = 2;
//            $val['lang'] = 2;   //1=>中文,2=>英文
//        });

        //3.歐元
        $url = config('xmlurl.eur-eng');
        $remote_data = xml2arr($url);
        $eur_data = $remote_data['commentary'];
        array_walk($eur_data, function(&$val) {
            $val['type'] = 3;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //4.日元
        $url = config('xmlurl.jpy-eng');
        $remote_data = xml2arr($url);
        $jpy_data = $remote_data['commentary'];
        array_walk($jpy_data, function(&$val) {
            $val['type'] = 4;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });
        //5.英鎊
        $url = config('xmlurl.gbp-eng');
        $remote_data = xml2arr($url);
        $gbp_data = $remote_data['commentary'];
        array_walk($gbp_data, function(&$val) {
            $val['type'] = 5;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //6.端郎
        $url = config('xmlurl.chf-eng');
        $remote_data = xml2arr($url);
        $chf_data = $remote_data['commentary'];
        array_walk($chf_data, function(&$val) {
            $val['type'] = 6;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //7.澳元
        $url = config('xmlurl.aud-eng');
        $remote_data = xml2arr($url);
        $aud_data = $remote_data['commentary'];
        array_walk($aud_data, function(&$val) {
            $val['type'] = 7;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //8.紐元
        $url = config('xmlurl.nzd-eng');
        $remote_data = xml2arr($url);
        $nzd_data = $remote_data['commentary'];
        array_walk($nzd_data , function(&$val) {
            $val['type'] = 8;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

        //9.加元
        $url = config('xmlurl.cad-eng');
        $remote_data = xml2arr($url);
        $cad_data = $remote_data['commentary'];
        array_walk($cad_data , function(&$val) {
            $val['type'] = 9;
            $val['lang'] = 2;   //1=>中文,2=>英文
        });

//        $data = array_merge($xau_data, $xag_data, $eur_data, $jpy_data, $gbp_data, $chf_data, $aud_data, $nzd_data, $cad_data);
        $data = array_merge($xau_data, $eur_data, $jpy_data, $gbp_data, $chf_data, $aud_data, $nzd_data, $cad_data);

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
