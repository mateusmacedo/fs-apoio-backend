<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Loggers\Interfaces\EventLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class EventLogger implements EventLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function eventoDisparado(string $event, string $msg): void
    {
        $this->logger->debug('### EVENTO DISPARADO ###');
        $this->logger->debug('EVENT: ' . $event);
        $this->logger->debug('MSG: ' . $msg);
    }

    public function metodoExecutado(string $metodo, array $args): void
    {
        $this->logger->debug('### METODO DE EVENTO EXECUTADO ###');
        $this->logger->debug('EVENT: ' . $metodo);
        $this->logger->debug('MSG: ' . json_encode($args));
    }

    public function listenerIniciado(string $listener): void
    {
        $this->logger->debug('### LISTENER INICIADO ###');
        $this->logger->debug('LISTENER: ' . $listener);
    }

    public function eventoRealizado(string $result): void
    {
        $this->logger->debug('### EVENTO REALIZADO ###');
        $this->logger->debug('RESULT: ' . $result);
    }

    public function eventoFalhou(Exception $exception): void
    {
        $this->logger->debug('### EVENTO FALHOU EXCEPTION ###');
        $this->logger->debug($exception->getMessage());
    }

    public function eventoFinalizado(): void
    {
        $this->logger->debug('### JOB FINALIZADO ###');
    }
}
