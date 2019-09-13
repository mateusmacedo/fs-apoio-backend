<?php


namespace App\Services\Application\Loggers\Interfaces;


use Exception;

interface JobsLoggerInterface
{
    public function jobIniciado(string $job, string $msg): void;

    public function jobRealizado(string $result): void;

    public function jobFalhou(Exception $exception): void;

    public function jobFinalizado(): void;

    public function jobRedirecionado(string $fila): void;
}
