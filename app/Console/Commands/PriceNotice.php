<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class PriceNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:price_notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url = 'http://www3.mw801.com/gen_quote/flat.txt';
        $remote_data = file_get_contents($url);
//        var_export($remote_data);die;
        $data_arr = explode(' ', $remote_data);
//        var_export($data_arr);
        $data = [];
        //EUR 欧元 type=1
        $data['EUR'] = array_slice($data_arr, 2,5);
        $data['EUR'][5] = $data_arr[0];
        $data['EUR'][6] = 1;
        //JPY 日元 type=2
        $data['JPY'] = array_slice($data_arr, 8, 5);
        $data['JPY'][5] = $data_arr[0];
        $data['JPY'][6] = 2;
        //GBP 英镑 type=3
        $data['GBP'] = array_slice($data_arr, 14, 5);
        $data['GBP'][5] = $data_arr[0];
        $data['GBP'][6] = 3;
        //CHF 瑞郎 type=4
        $data['CHF'] = array_slice($data_arr, 20, 5);
        $data['CHF'][5] = $data_arr[0];
        $data['CHF'][6] = 4;
        //AUD 澳元 type=5
        $data['AUD'] = array_slice($data_arr, 26, 5);
        $data['AUD'][5] = $data_arr[0];
        $data['AUD'][6] = 5;
        //NZD 纽元 type=6
        $data['NZD'] = array_slice($data_arr, 32, 5);
        $data['NZD'][5] = $data_arr[0];
        $data['NZD'][6] = 6;
        //CAD 加元 type=7
        $data['CAD'] = array_slice($data_arr, 38, 5);
        $data['CAD'][5] = $data_arr[0];
        $data['CAD'][6] = 7;
        //EUJP 欧日 type=8
        $data['EUJP'] = array_slice($data_arr, 118, 5);
        $data['EUJP'][5] = $data_arr[116];
        $data['EUJP'][6] = 8;
        //EUCF 欧瑞 type=9
        $data['EUCF'] = array_slice($data_arr, 124, 5);
        $data['EUCF'][5] = $data_arr[116];
        $data['EUCF'][6] = 9;
        //EUGP  欧英 type=10
        $data['EUGP'] = array_slice($data_arr, 130, 5);
        $data['EUGP'][5] = $data_arr[116];
        $data['EUGP'][6] = 10;
        //CFJP  瑞日 type=11
        $data['CFJP'] = array_slice($data_arr, 136, 5);
        $data['CFJP'][5] = $data_arr[116];
        $data['CFJP'][6] = 11;
        //ADJP  澳日 type=12
        $data['ADJP'] = array_slice($data_arr, 142, 5);
        $data['ADJP'][5] = $data_arr[116];
        $data['ADJP'][6] = 12;
        //HKG  港金 type=13
        $data['HKG'] = array_slice($data_arr, 93, 5);
        $data['HKG'][5] = $data_arr[43];
        $data['HKG'][6] = 13;
        //LLG 黄金 type=14
        $data['LLG'] = array_slice($data_arr, 99, 5);
        $data['LLG'][5] = $data_arr[43];
        $data['LLG'][6] = 14;
        //LLS 白银 type=15
        $data['LLS'] = array_slice($data_arr, 105, 5);
        $data['LLS'][5] = $data_arr[43];
        $data['LLS'][6] = 15;
        //HLG 港敦 type=16
        $data['HLG'] = array_slice($data_arr, 111, 5);
        $data['HLG'][5] = $data_arr[43];
        $data['HLG'][6] = 16;
        //TT type=17
        $data['TT'] = array_slice($data_arr, 86, 5);
        $data['TT'][5] = $data_arr[43];
        $data['TT'][6] = 17;
//        var_export($data);die;
        DB::table('screen_price')->truncate();
        foreach ($data as $k => $v) {
            $insert_array = [
                $v[0], $v[1], $v[2], $v[3], $v[4], $v[5], $v[6]
            ];
            $res = DB::insert('insert into stock_screen_price set now=?, highest=?, lowest=?, today=?,yesterday=?,time=?, type= ?', $v);
        }
        return true;
    }

}
