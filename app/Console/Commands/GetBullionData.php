<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetBullionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_bullion_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get bullion data everyFiveMinutes';

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
        $url = config('xmlurl.ref-bullion');
        $remote_data = xml2arr($url);
        //贵金属数据
        $bullion_data = $remote_data['details'];
        if (empty($bullion_data)) return;
        $monthly_data = $bullion_data['monthly'];
        $weekly_data  = $bullion_data['weekly'];
        $daily_data   = $bullion_data['daily'];
        //替换更新stock_ref_bullion表数据
        $insert_data = [
            'monthly'       =>  serialize($monthly_data),
            'weekly'        =>  serialize($weekly_data),
            'daily'         =>  serialize($daily_data),
            'create_time'   =>  time(),
        ];
        $res = DB::table('ref_bullion')->insert($insert_data);
        return;
    }
}
