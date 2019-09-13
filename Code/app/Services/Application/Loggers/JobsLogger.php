<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\JobsLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class JobsLogger implements JobsLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function jobIniciado(string $job, string $msg): void
    {
        $this->logger->debug('### JOB INICIADA ###');
        $this->logger->debug('JOB: ' . $job);
        $this->logger->debug('MSG: ' . $msg);
    }

    public function jobRealizado(string $result): void
    {
        $this->logger->debug('### JOB REALIZADO ###');
        $this->logger->debug('RESULT: ' . $result);
    }

    public function jobFalhou(Exception $exception): void
    {
        $this->logger->debug('### JOB FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function jobFinalizado(): void
    {
        $this->logger->debug('### JOB FINALIZADO ###');
    }

    public function jobRedirecionado(string $fila): void
    {
        $this->logger->debug('### JOB REDIRECIONADO ###');
        $this->logger->debug('Fila: ' . $fila);
    }
}
