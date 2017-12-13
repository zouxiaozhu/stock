<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetNoticeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_notice_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get notice data everyFiveMinutes';

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
        $url = config('xmlurl.notice');
        $remote_data = xml2arr($url);
//        var_export($remote_data);die;
        $notice_data = $remote_data['newsitem'];
        if (empty($notice_data)) return;
        //选择最后一次发公告的时间  type 1=>财经新闻, 2=>英皇公告
        $data = DB::table('news')
            ->select('publish_date_time')
            ->where('type', 2)
            ->orderBy('publish_date_time', 'desc')
            ->take(1)
            ->get();
        $last_publish_time = empty($data) ? 0 : $data[0]->publish_date_time;
        $notice_data = array_filter($notice_data,function($v) use($last_publish_time){
            return strtotime($v['publish_date_time']) > $last_publish_time ;
        });
        //没有要更新的数据则return
        if (empty($notice_data)) return;
        foreach ($notice_data as $k => $v) {
            $notice_update_data = [
                $v['news_id'],
                strtotime($v['publish_date_time']),
                $v['category'],
                serialize($v['image_link']),
                serialize($v['headline']),
                time(),
                2
            ];
            $res = DB::insert('replace into stock_news values(?,?,?,?,?,?,?)',$notice_update_data);
            if (!$res) continue;
            //替换更新content表
            $content_update_data = [$v['news_id'], 3, $v['content']];
            DB::insert('replace into stock_content values(?,?,?)', $content_update_data);
        }
        return;
    }
}
