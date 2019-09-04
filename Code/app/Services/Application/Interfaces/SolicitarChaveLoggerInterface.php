<?php


namespace App\Services\Application\Interfaces;


use Exception;
use Illuminate\Http\Response;

interface SolicitarChaveLoggerInterface
{
    public function solicitarChaveIniciada(array $dados): void;

    public function solicitarChaveRealizada(Response $response): void;

    public function solicitarChaveFalhou(Exception $exception): void;

    public function solicitarChaveFinalizou(): void;
}
