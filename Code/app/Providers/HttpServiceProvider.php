<?php

namespace App\Providers;

use App\Services\Application\Factories\HttpServiceFactory;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Application\Interfaces\ClaroHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\ClaroHttpService');
        });
        $this->app->bind('App\Services\Application\Interfaces\GvtHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\GvtHttpService');
        });
        $this->app->bind('App\Services\Application\Interfaces\HeroHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\HeroHttpService');
        });
        $this->app->bind('App\Services\Application\Interfaces\OiHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\OiHttpService');
        });
        $this->app->bind('App\Services\Application\Interfaces\TimHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\TimHttpService');
        });
        $this->app->bind('App\Services\Application\Interfaces\VivoHttpService', static function () {
            return HttpServiceFactory::create('App\Services\Application\Interfaces\VivoHttpService');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
