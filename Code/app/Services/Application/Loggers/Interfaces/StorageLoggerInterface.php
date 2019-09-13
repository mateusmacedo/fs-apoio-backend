<?php


namespace App\Services\Application\Loggers\Interfaces;


use Exception;
use SplFileInfo;

interface StorageLoggerInterface
{
    public function storageIniciado(SplFileInfo $file): void;

    public function storageRealizado(string $filepath): void;

    public function storageFalhou(Exception $exception): void;

    public function storageFinalizado(): void;

    public function getFileIniciado(string $disk, string $filename): void;

    public function getFileFalhou(Exception $exception): void;

    public function getFileRealizado(): void;
}
