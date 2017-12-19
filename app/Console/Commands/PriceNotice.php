<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
//        var_export($data_arr);die;
    }

}
