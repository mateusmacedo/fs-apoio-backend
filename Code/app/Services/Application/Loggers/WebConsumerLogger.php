<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Interfaces\PayloadInterface;
use App\Services\Application\Interfaces\WebConsumerLoggerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class WebConsumerLogger implements WebConsumerLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function requestIniciada(PayloadInterface $payload): void
    {
        $this->logger->debug('### REQUEST INICIADA ###');
        $this->logger->debug('### PAYLOAD ENVIADO START ###');
        $this->logger->debug($payload);
        $this->logger->debug('### PAYLOAD ENVIADO END ###');

    }

    public function requestRealizada(string $statusCode, array $headers, string $contents): void
    {
        $this->logger->debug('### REQUEST REALIZADA ###');
        $this->logger->debug('### REQUEST RESULT START ###');
        $this->logger->debug('Code: ' . $statusCode);
        $this->logger->debug('Headers: ' . json_encode($headers));
        $this->logger->debug('Body: ' . $contents);
        $this->logger->debug('### REQUEST RESULT END ###');
    }

    public function requestFalhou(Exception $exception): void
    {
        $this->logger->debug('### REQUEST FALHOU ###');
        $this->logger->debug('### EXCEPTION LANÇADA START ###');
        $this->logger->debug($exception);
        $this->logger->debug('### EXCEPTION LANÇADA END ###');
    }

    public function requestFinalizou(): void
    {
        $this->logger->debug('### REQUEST FINALIZADA ###');
    }
}
