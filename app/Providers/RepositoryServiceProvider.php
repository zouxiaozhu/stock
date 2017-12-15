<?php

namespace App\Providers;


use App\Repositories\ImplementsResp\SyncData;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;
use App\Repositories\ImplementsResp\AboutOur;
use App\Repositories\RepositoryInterfaces\AboutOurInterface;
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
        app()->bind(SyncDataInterface::class,SyncData::class);
        app()->bind(AboutOurInterface::class,AboutOur::class);
    }
}
