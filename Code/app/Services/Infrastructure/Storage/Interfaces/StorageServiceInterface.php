<?php


namespace App\Services\Infrastructure\Storage\Interfaces;


use App\Services\Infrastructure\Storage\AbstractStorageService;
use Psr\Http\Message\ResponseInterface;
use SplFileInfo;

interface StorageServiceInterface
{
    public function setBasePath(string $basePath): AbstractStorageService;

    public function store(string $fileName, SplFileInfo $file): string;

    public function delete(string $fileName): bool;

    public function getUrl($fileName): string;

    public function download($fileName): ResponseInterface;
}
