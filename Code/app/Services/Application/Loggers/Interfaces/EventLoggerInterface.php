<?php


namespace App\Services\Application\Loggers\Interfaces;


interface EventLoggerInterface
{
    public function eventoDisparado(string $event, string $msg): void;

    public function metodoExecutado(string $metodo, array $args): void;

    public function listenerIniciado(string $listener): void;
}
