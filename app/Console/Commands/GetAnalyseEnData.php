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
        //澳元
        $url = config('xmlurl.aud-eng');
        $remote_data = xml2arr($url);
        $aud_data = $remote_data['commentary'];
        $this->_syncData($aud_data, 7);

        //紐元
        $url = config('xmlurl.nzd-eng');
        $remote_data = xml2arr($url);
        $nzd_data = $remote_data['commentary'];
        $this->_syncData($mzd_data, 8);
    }


    private function _syncData($data, $type = 1)
    {
        if (empty($data)) return true;
        foreach ($data as $k => $v) {
            $update_data = [
                $v['id'],
                strtotime($v['date']),
                serialize($v['title']),
                $type,
                $v['content'],
                time()
            ];
            $res = DB::insert('replace into stock_analy_en values(?,?,?,?,?,?)', $update_data);
            var_export($res);die;
        }
        return true;
    }

}
