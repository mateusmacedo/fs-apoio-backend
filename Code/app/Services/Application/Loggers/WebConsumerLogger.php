<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Loggers\Interfaces\WebConsumerLoggerInterface;
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

    /**
     * @param PayloadInterface $payload
     * @todo logResquestIniciadaTestCase
     */
    public function requestIniciada(PayloadInterface $payload): void
    {
        $this->logger->debug('### REQUEST INICIADA PAYLOAD ###');
        $this->logger->debug($payload);

    }

    /**
     * @param string $statusCode
     * @param array $headers
     * @param string $contents
     * @todo logResquestRealizadaTestCase
     */
    public function requestRealizada(string $statusCode, array $headers, string $contents): void
    {
        $this->logger->debug('### REQUEST REALIZADA RESULT ###');
        $this->logger->debug('Code: ' . $statusCode);
        $this->logger->debug('Headers: ' . json_encode($headers));
        $this->logger->debug('Body: ' . $contents);
    }

    /**
     * @param Exception $exception
     * @todo logRequestFalhouTestCase
     */
    public function requestFalhou(Exception $exception): void
    {
        $this->logger->debug('### REQUEST FALHOU EXCEPTION ###');
        $this->logger->debug($exception);
    }

    /**
     * @todo logRequestFinalizouTestCase
     */
    public function requestFinalizou(): void
    {
        $this->logger->debug('### REQUEST FINALIZADA ###');
    }
}
