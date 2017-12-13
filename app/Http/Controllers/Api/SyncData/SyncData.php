<?php

namespace App\Http\Controllers\Api\SyncData;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;


class SyncData extends Controller
{
    //
    protected $syncData;

    public function __construct(Request $request, SyncDataInterface $syncData)
    {
        echo 111;die;
        $this->syncData = $syncData;
    }

    public function demo()
    {
        $this->syncData->demo([]);
    }
}
