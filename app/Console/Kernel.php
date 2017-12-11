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
        $schedule->command('cron:get_event_data')->everyMinute();
        $schedule->command('cron:get_bullion_data')->everyMinute();
        $schedule->command('cron:get_forex_data')->everyMinute();
        $schedule->command('cron:get_news_data')->everyMinute();
        $schedule->command('cron:get_strong_weak_data')->everyMinute();
    }
}
