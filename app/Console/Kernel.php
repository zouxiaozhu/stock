<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\GetEventData::class,           //财经日志数据
        Commands\GetNewsData::class,            //财经新闻数据
        Commands\GetBullionData::class,         //贵金属价位参考书
        Commands\GetForexData::class,           //外汇价位参考数据
        Commands\GetStrongWeakData::class,      //强弱指数
        Commands\GetNoticeData::class,          //英皇公告
        Commands\GetEconData::class,            //经济数据
        Commands\GetAnalyseEnData::class,       //每日分析(英文版)
        Commands\GetAnalyseCnData::class,       //每日分析(中文版)
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('cron:get_event_data')->everyFiveMinutes();
        $schedule->command('cron:get_bullion_data')->everyFiveMinutes();
        $schedule->command('cron:get_forex_data')->everyFiveMinutes();
        $schedule->command('cron:get_news_data')->everyFiveMinutes();
        $schedule->command('cron:get_strong_weak_data')->everyFiveMinutes();
        $schedule->command('cron:get_notice_data')->everyFiveMinutes();
        $schedule->command('cron:get_econ_data')->everyFiveMinutes();
        $schedule->command('cron:get_analyse_en_data')->everyFiveMinutes();
        $schedule->command('cron:get_analyse_cn_data')->everyFiveMinutes();
    }
}
