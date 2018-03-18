<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetEconData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_econ_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get event data everyFiveMinutes';

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
        $url = config('xmlurl.econ');
        $remote_data = xml2arr($url);
        $econ_data = $remote_data['figure'];
        if (empty($econ_data)) return;

        foreach ($econ_data as $k => $v) {
            $econ_update_data = [
                $v['id'],
                strtotime($v['date']),
                empty($v['hktime']) ? '' : trim($v['hktime']),
                empty($v['country']) ? '' : trim($v['country']),
                empty($v['fname']) ? '' : trim($v['fname']),
                empty($v['quarter']) ? '' : trim($v['quarter']),
                intval($v['month']),
                empty($v['forecast']) ? '' : trim($v['forecast']),
                empty($v['lasttime']) ? '' : trim($v['lasttime']),
                empty($v['value']) ? '' : trim($v['value']),
                time(),
            ];
            DB::insert('replace into stock_econ values(?,?,?,?,?,?,?,?,?,?,?)', $econ_update_data);
        }
        return;
    }
}
