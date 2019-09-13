<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\StorageLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use SplFileInfo;

class StorageLogger implements StorageLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function storageIniciado(SplFileInfo $file): void
    {
        $this->logger->debug('### STORAGE INICIADO ###');
        $this->logger->debug($file->getBasename());
    }

    public function storageRealizado(string $filepath): void
    {
        $this->logger->debug('### STORAGE REALIZADA ###');
        $this->logger->debug($filepath);
    }

    public function storageFalhou(Exception $exception): void
    {
        $this->logger->debug('### STORAGE FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function storageFinalizado(): void
    {
        $this->logger->debug('### STORAGE FINALIZADA ###');
    }

    public function getFileIniciado(string $disk, string $filename): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO INICIADA ###');
        $this->logger->debug($filename);
    }

    public function getFileFalhou(Exception $exception): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function getFileRealizado(): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO FINALIZADA ###');
    }
}
