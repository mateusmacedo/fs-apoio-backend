<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\ImporterLoggerInterface;
use Exception;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class ImporterLogger implements ImporterLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function importacaoIniciada(): void
    {
        $this->logger->debug('### IMPORTACAO INICIADA ###');
    }

    public function collectionRecebida(Collection $collection): void
    {
        $this->logger->debug('### COLLECTION ###');
        $this->logger->debug($collection->toJson());
    }

    public function rowRecebida($row): void
    {
        $this->logger->debug('### ROW ###');
        $this->logger->debug($row);
    }

    public function importacaoRealizada(): void
    {
        $this->logger->debug('### IMPORTACAO REALIZADA ###');
    }

    public function importacaoFalhou(Exception $exception, Collection $collection, array $row): void
    {
        $this->logger->debug('### IMPORTACAO FALHOU EXCEPTION ###');
        $this->logger->debug('COLLECTION DATA: ' . $collection->toJson());
        $this->logger->debug('ROW DATA: ' . json_encode($row));
        $this->logger->debug($exception->getMessage());
    }

    public function importacaoFinalizada(): void
    {
        $this->logger->debug('### IMPORTACAO FINALIZADA ###');
    }
}
