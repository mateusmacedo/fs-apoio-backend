<?php


namespace App\Services\Infrastructure\Storage\Interfaces;


use Illuminate\Http\File;

interface LocalStorageServiceInterface
{
    public function getFullPath($fileName): string;

    public function getFile($fileName): File;
}
