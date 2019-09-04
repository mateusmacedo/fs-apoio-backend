<?php

namespace App\Providers;

use App\Services\Application\Loggers\SolicitarChaveLogger;
use App\Services\Application\Loggers\WebConsumerLogger;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\Application\Interfaces\WebConsumerLoggerInterface', static function () {
            $logger = new Logger('web-consumer');
            $handler = new StreamHandler(storage_path('logs/web-consumer.log'));
            $logger->pushHandler($handler);
            return new WebConsumerLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Interfaces\SolicitarChaveLoggerInterface', static function () {
            $logger = new Logger('solicitar-chave');
            $handler = new StreamHandler(storage_path('logs/solicitar-chave.log'));
            $logger->pushHandler($handler);
            return new SolicitarChaveLogger($logger);
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
