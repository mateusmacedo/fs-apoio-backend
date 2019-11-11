<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\DomainLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class DomainLogger implements DomainLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function operacaoIniciada(array $data): void
    {
        $this->logger->debug('### OPERAÇÃO INICIADA ###');
        $this->logger->debug(json_encode($data));

    }

    public function operacaoRealizada(array $result): void
    {
        $this->logger->debug('### OPERAÇÃO REALIZADA RESULT ###');
        $this->logger->debug(json_encode($result));
    }

    public function operacaoFalhou(Exception $exception): void
    {
        $this->logger->debug('### OPERAÇÃO FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function operacaoFinalizou(): void
    {
        $this->logger->debug('### OPERAÇÃO FINALIZADA ###');
    }
}
