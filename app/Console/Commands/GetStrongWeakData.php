<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

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
    protected $description = 'Get strong_weak data everyFiveMinutes';

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
        $relative_data = $remote_data['relative'];
        if (empty($relative_data)) return;

        $update_data = [
            $relative_data['id'],
            strtotime($relative_data['date']),
            $relative_data['xau'],
            $relative_data['xag'],
            $relative_data['eur'],
            $relative_data['jpy'],
            $relative_data['gbp'],
            $relative_data['chf'],
            $relative_data['aud'],
            $relative_data['nzd'],
            $relative_data['cad'],
        ];
        $res = DB::insert('replace into stock_relative values(?,?,?,?,?,?,?,?,?,?,?)', $update_data);
        return;
    }
}
