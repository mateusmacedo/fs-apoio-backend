<?php


namespace App\Services\Application\Loggers\Interfaces;


use Exception;

interface DomainLoggerInterface
{
    public function operacaoIniciada(array $data): void;

    public function operacaoRealizada(array $result): void;

    public function operacaoFalhou(Exception $exception): void;

    public function operacaoFinalizou(): void;
}
