<?php

/**
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/13
 * Time: 下午7:44
 */
namespace App\Repositories\ImplementResp;

use DB;
use Illuminate\Support\Arr;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;

class SyncData implements SyncDataInterface
{

    public function eventData($data)
    {
        if (isset($data['time'])) {
            $data = DB::table('event')->select('event_id', 'event_date', 'title')->get();
            return $data;
        }
        $current_time = time();
        $data = DB::table('event')
            ->select('event_id', 'event_date', 'title')
            ->where('display_start_time', '<', $current_time)
            ->where('display_end_time', '>', $current_time)
            ->orderBy('event_date', 'desc')
            ->get();
        return $data;
//        return response()->success($data);
    }

}