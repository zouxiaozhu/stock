<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetForexData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_forex_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get forex data everyFiveMinutes';

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
        $url = config('xmlurl.ref-forex');
        $remote_data = xml2arr($url);
        $forex_data  = $remote_data['details'];
        if (empty($forex_data)) return;
        $insert_data = [
            'res1'          =>  serialize($forex_data['res1']),
            'res2'          =>  serialize($forex_data['res2']),
            'res3'          =>  serialize($forex_data['res3']),
            'res4'          =>  serialize($forex_data['res4']),
            'sup1'          =>  serialize($forex_data['sup1']),
            'sup2'          =>  serialize($forex_data['sup2']),
            'sup3'          =>  serialize($forex_data['sup3']),
            'sup4'          =>  serialize($forex_data['sup4']),
            'create_time'   =>  time(),
        ];
        $res = DB::table('ref_forex')->insert($insert_data);
        return;
    }
}
