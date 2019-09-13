<?php


namespace App\Services\Infrastructure\Storage;


use App\Services\Application\Loggers\Interfaces\StorageLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\LocalStorageServiceInterface;
use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class LocalStorageService extends AbstractStorageService implements LocalStorageServiceInterface
{
    public function __construct(StorageLoggerInterface $logger)
    {
        $this->disk = 'local';
        parent::__construct($logger);
    }

    public function getFile($filename): File
    {
        try {
            $this->logger->getFileIniciado($this->disk, $filename);
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new RuntimeException(self::NOT_FOUND);
            }
            return new File($this->getFullPath($filename));
        } catch (Exception $exception) {
            $this->logger->getFileFalhou($exception);
            throw new RuntimeException($exception->getMessage());
        } finally {
            $this->logger->getFileRealizado();
        }
    }

    public function getFullPath($filename): string
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new RuntimeException(self::NOT_FOUND);
            }
            return storage_path('app/' . $path);
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
