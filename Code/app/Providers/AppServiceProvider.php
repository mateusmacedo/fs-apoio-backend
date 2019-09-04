<?php

namespace App\Providers;

use App\Services\Application\Factories\RequestFactory;
use App\Services\Application\GuzzleHttpClient;
use App\Services\Application\WebConsumer;
use GuzzleHttp\Client;
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
        $this->app->bind('App\Services\Application\Interfaces\WebConsumerInterface', static function ($app) {
            return new WebConsumer(
                app('App\Services\Application\Interfaces\ClientInterface'),
                app('App\Services\Application\Interfaces\RequestFactoryInterface'),
                app('App\Services\Application\Interfaces\WebConsumerLoggerInterface')
            );
        });
        $this->app->bind('App\Services\Application\Interfaces\ClientInterface', static function ($app) {
            return new GuzzleHttpClient(new Client());
        });
        $this->app->bind('App\Services\Application\Interfaces\RequestFactoryInterface', static function ($app) {
            return new RequestFactory();
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
