<?php

namespace App\Providers;

use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('cache', 'Illuminate\Cache\CacheManager');
        $this->app->alias('auth', 'Illuminate\Auth\AuthManager');

        LumenPassport::routes($this->app->router);
    }
}
