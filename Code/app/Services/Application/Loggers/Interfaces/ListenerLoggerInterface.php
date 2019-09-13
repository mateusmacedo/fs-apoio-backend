<?php


namespace App\Services\Application\Loggers\Interfaces;


use Exception;

interface ListenerLoggerInterface
{
    public function listenerDisparado(string $listener, string $msg): void;

    public function listenerRealizado(string $result): void;

    public function listenerFalhou(Exception $exception): void;

    public function listenerFinalizado(): void;
}
