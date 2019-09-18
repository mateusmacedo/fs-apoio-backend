<?php


namespace App\Services\Application\Loggers\Interfaces;


use Exception;
use Illuminate\Support\Collection;
use SplFileInfo;

interface ImporterLoggerInterface
{
    /**
     * @param SplFileInfo $file
     */
    public function importacaoIniciada(): void;

    public function collectionRecebida(Collection $collection): void;

    public function rowRecebida($row): void;

    public function importacaoRealizada(): void;

    public function importacaoFalhou(Exception $exception, Collection $collection, array $row): void;

    public function importacaoFinalizada(): void;
}
