<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GetNewsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:get_news_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get news data everyFiveMinutes';

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
        $url = config('xmlurl.news');
        $remote_data = xml2arr($url);
        $newsitem = $remote_data['newsitem'];
        if (empty($newsitem)) return;
        $data = DB::table('news')
            ->select('publish_date_time')
            ->orderBy('publish_date_time', 'desc')
            ->take(1)
            ->get();
        $last_publish_time = empty($data) ? 0 : $data[0]->publish_date_time;
        $news_data = array_filter($newsitem,function($v) use($last_publish_time){
            return strtotime($v['publish_date_time']) > $last_publish_time ;
        });
        //没有要更新的数据则return
        if (empty($news_data)) return;
        foreach ($news_data as $k => $v) {
            $news_update_data = [
                $v['news_id'],
                strtotime($v['publish_date_time']),
                $v['category'],
                serialize($v['image_link']),
                serialize($v['headline']),
                time()
            ];
            $res = DB::insert('replace into stock_news values(?,?,?,?,?,?)',$news_update_data);
            if (!$res) continue;
            //替换更新content表
            $content_update_data = [$v['news_id'], 2, $v['content']];
            DB::insert('replace into stock_content values(?,?,?)', $content_update_data);
        }
        return;
    }
}
