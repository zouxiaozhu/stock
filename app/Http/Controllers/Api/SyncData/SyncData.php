<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Repositories\RepositoryInterfaces\TestInterface;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;


class SyncData extends Controller
{
    //
    protected $syncData;

    public function __construct(Request $request, TestInterface $test,SyncDataInterface $sync)
    {

        $sync->demos(1111);
    }

    public function demo()
    {

    }
}
