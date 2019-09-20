<?php

namespace App\Providers;

use App\Services\Application\Loggers\DomainLogger;
use App\Services\Application\Loggers\EventLogger;
use App\Services\Application\Loggers\ImporterLogger;
use App\Services\Application\Loggers\JobsLogger;
use App\Services\Application\Loggers\ListenerLogger;
use App\Services\Application\Loggers\StorageLogger;
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
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\DomainLoggerInterface', static function () {
            $logger = new Logger('domain');
            $handler = new StreamHandler(storage_path('logs/domain.log'));
            $logger->pushHandler($handler);
            return new DomainLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\WebConsumerLoggerInterface', static function () {
            $logger = new Logger('web-consumer');
            $handler = new StreamHandler(storage_path('logs/web-consumer.log'));
            $logger->pushHandler($handler);
            return new WebConsumerLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\StorageLoggerInterface', static function () {
            $logger = new Logger('storage');
            $handler = new StreamHandler(storage_path('logs/storage.log'));
            $logger->pushHandler($handler);
            return new StorageLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\ImporterLoggerInterface', static function () {
            $logger = new Logger('import');
            $handler = new StreamHandler(storage_path('logs/import.log'));
            $logger->pushHandler($handler);
            return new ImporterLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\JobsLoggerInterface', static function () {
            $logger = new Logger('jobs');
            $handler = new StreamHandler(storage_path('logs/jobs.log'));
            $logger->pushHandler($handler);
            return new JobsLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\EventLoggerInterface', static function () {
            $logger = new Logger('events');
            $handler = new StreamHandler(storage_path('logs/events.log'));
            $logger->pushHandler($handler);
            return new EventLogger($logger);
        });
        $this->app->singleton('App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface', static function () {
            $logger = new Logger('listener');
            $handler = new StreamHandler(storage_path('logs/listener.log'));
            $logger->pushHandler($handler);
            return new ListenerLogger($logger);
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
