<?php


namespace App\Services\Application\Interfaces;


use Exception;

interface WebConsumerLoggerInterface
{
    public function requestIniciada(PayloadInterface $payload): void;

    public function requestRealizada(string $statusCode, array $headers, string $contents): void;

    public function requestFalhou(Exception $exception): void;

    public function requestFinalizou(): void;
}
