<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class ListenerLogger implements ListenerLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function listenerDisparado(string $listener, string $msg): void
    {
        $this->logger->debug('### LISTENER DISPARADO ###');
        $this->logger->debug('LISTENER: ' . $listener);
        $this->logger->debug('MSG: ' . $msg);
    }

    public function listenerRealizado(string $result): void
    {
        $this->logger->debug('### LISTENER REALIZADO ###');
        $this->logger->debug('RESULT: ' . $result);
    }

    public function listenerFalhou(Exception $exception): void
    {
        $this->logger->debug('### LISTENER FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function listenerFinalizado(): void
    {
        $this->logger->debug('### LISTENER FINALIZADO ###');
    }
}
