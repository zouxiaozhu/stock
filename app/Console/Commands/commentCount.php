<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Api\SyncData\SyncData;
use DB;

class commentCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:comment_count';

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
    public function __construct(SyncData $syncData)
    {
        parent::__construct();
        $this->sync = $syncData;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = DB::table('comments')->where('status', 2)->count();
        $this->sync->sendMailAce(env('PUSH_ADMIN_EAMIL','shengyulong@gmail.com'), '评论管理', '有评论待审核,请前往后台查看');
    }
}
