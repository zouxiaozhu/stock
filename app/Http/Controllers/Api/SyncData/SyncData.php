<?php

namespace App\Http\Controllers\Api\SyncData;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;


class SyncData extends Controller
{
    protected $syncData;

    public function __construct(Request $request, SyncDataInterface $sync)
    {
        $this->syncData = $sync;
    }


    public function eventData(Request $request)
    {
        $data = [];
        if ($request->has('time')) {
            $data['time'] = intval($request->get('time'));
        }
        $result = $this->syncData->eventData($data);
        return response()->success($result);
    }


}
