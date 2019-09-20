<?php

namespace App\Providers;

use App\Imports\SolicitarChaveImport;
use App\Services\Application\Http\Factories\RequestFactory;
use App\Services\Application\Http\GuzzleHttpClient;
use App\Services\Application\Http\WebConsumer;
use App\Services\Domain\ClientsDomainService;
use App\Services\Infrastructure\Storage\LocalStorageService;
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
        $this->app->bind('App\Services\Domain\ClientDomainServiceInterface', static function ($app) {
            return new ClientsDomainService(
                $app->make('App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface'),
                $app->make('App\Services\Application\Loggers\Interfaces\DomainLoggerInterface')
            );
        });
        $this->app->bind('App\Services\Application\Http\Interfaces\WebConsumerInterface', static function ($app) {
            return new WebConsumer(
                $app->make('App\Services\Application\Http\Interfaces\ClientInterface'),
                $app->make('App\Services\Application\Http\Interfaces\RequestFactoryInterface'),
                $app->make('App\Services\Application\Loggers\Interfaces\WebConsumerLoggerInterface')
            );
        });
        $this->app->bind('App\Services\Application\Http\Interfaces\ClientInterface', static function () {
            return new GuzzleHttpClient(new Client());
        });
        $this->app->bind('App\Services\Application\Http\Interfaces\RequestFactoryInterface', static function () {
            return new RequestFactory();
        });
        $this->app->bind('App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface', static function ($app) {
            return new LocalStorageService($app->make('App\Services\Application\Loggers\Interfaces\StorageLoggerInterface'));
        });
        $this->app->bind('App\Imports\SolicitarChaveImport', static function ($app) {
            return new SolicitarChaveImport($app->make('App\Services\Application\Loggers\Interfaces\ImporterLoggerInterface'));
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
