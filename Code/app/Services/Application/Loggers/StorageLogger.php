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

    /**
     * @param SplFileInfo $file
     * @todo storageInciadoTestCase
     */
    public function storageIniciado(SplFileInfo $file): void
    {
        $this->logger->debug('### STORAGE INICIADO ###');
        $this->logger->debug($file->getBasename());
    }

    /**
     * @param string $filepath
     * @todo logStorageRealizadoTestCase
     */
    public function storageRealizado(string $filepath): void
    {
        $this->logger->debug('### STORAGE REALIZADA ###');
        $this->logger->debug($filepath);
    }

    /**
     * @param Exception $exception
     * @todo logStorageFalhouTestCase
     */
    public function storageFalhou(Exception $exception): void
    {
        $this->logger->debug('### STORAGE FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    /**
     * @todo logStorageFinalizadoTestCase
     */
    public function storageFinalizado(): void
    {
        $this->logger->debug('### STORAGE FINALIZADA ###');
    }


    /**
     * @param string $disk
     * @param string $filename
     * @todo logGetFileIniciadoTestCase
     */
    public function getFileIniciado(string $disk, string $filename): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO INICIADA ###');
        $this->logger->debug($filename);
    }

    /**
     * @param Exception $exception
     * @todo logGetFileFalhouTestCase
     */
    public function getFileFalhou(Exception $exception): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    /**
     * @todo logGetFileRealizadoTestCase
     */
    public function getFileRealizado(): void
    {
        $this->logger->debug('### RECUPERAÇÃO DE ARQUIVO FINALIZADA ###');
    }
}
