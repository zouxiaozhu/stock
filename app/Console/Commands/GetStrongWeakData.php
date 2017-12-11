<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetStrongWeakData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_strong_weak_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get strong_weak data everyMinute';

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
        $url = config('xmlurl.strong-weak');
        $remote_data = xml2arr($url);
//        var_export($remote_data);die;
    }
}
