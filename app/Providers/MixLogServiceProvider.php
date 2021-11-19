<?php

namespace App\Providers;

use App\Services\MixLogService;
use Illuminate\Support\ServiceProvider;

class MixLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('MixLogService', function($app){
            return new MixLogService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
