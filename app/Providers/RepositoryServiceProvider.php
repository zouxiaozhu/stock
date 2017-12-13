<?php

namespace App\Providers;


use App\Repositories\ImplementResp\SyncData;
use App\Repositories\ImplementResp\TestImp;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;
use App\Repositories\RepositoryInterfaces\TestInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(TestInterface::class,TestImp::class);
        app()->bind(SyncDataInterface::class,SyncData::class);
    }
}
