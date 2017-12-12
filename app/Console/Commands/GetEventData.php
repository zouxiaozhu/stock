<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

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
        //获取财经日志数据
        $url = config('xmlurl.event');
        $remote_data = xml2arr($url);
        $event_data = $remote_data['event'];
        if (empty($event_data)) return;
        //替换日志信息
        foreach ($event_data as $k => $v) {
            $year = substr($v['event_date'], 0, 4);
            if ($year < 1000 || $year > 9999) {
                $v['event_date'] = '1970';
            }
            $event_update_data = [
                $v['id'],
                strtotime($v['event_date']),
                strtotime($v['display_start_time']),
                strtotime($v['display_end_time']),
                $v['title'],
                time(),
            ];
            $res = DB::insert('replace into stock_event values(?,?,?,?,?,?)',$event_update_data);
            if (!$res) continue;
            //替换更新content表
            $content_update_data = [$v['id'], 1, $v['content']];
            DB::insert('replace into stock_content values(?,?,?)', $content_update_data);
        }
        return;
    }
}
