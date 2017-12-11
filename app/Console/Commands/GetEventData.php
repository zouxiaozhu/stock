<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_event_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get event data everyMinute';

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
        $url = config('xmlurl.event');
        $remote_data = xml2arr($url);
//        var_export($remote_data);die;
    }
}
