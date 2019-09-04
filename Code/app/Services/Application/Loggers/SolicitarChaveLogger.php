<?php


namespace App\Services\Application\Loggers;


use App\Services\Application\Interfaces\SolicitarChaveLoggerInterface;
use Exception;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class SolicitarChaveLogger implements SolicitarChaveLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function solicitarChaveIniciada(array $dados): void
    {
        $this->logger->debug('### REQUEST INICIADA ###');
        $this->logger->debug('### DADOS ENVIADOS START ###');
        $this->logger->debug(json_encode($dados));
        $this->logger->debug('### DADOS ENVIADOS END ###');

    }

    public function solicitarChaveRealizada(Response $response): void
    {
        $this->logger->debug('### EXECUÇÃO REALIZADA ###');
        $this->logger->debug('### EXECUÇÃO RESULT START ###');
        $this->logger->debug('Code: ' . json_encode($response->getStatusCode()));
        $this->logger->debug('Headers: ' . json_encode($response->headers));
        $this->logger->debug('Body: ' . json_encode($response->getContent()));
        $this->logger->debug('### EXECUÇÃO RESULT END ###');
    }

    public function solicitarChaveFalhou(Exception $exception): void
    {
        $this->logger->debug('### EXECUÇÃO FALHOU ###');
        $this->logger->debug('### EXCEPTION LANÇADA START ###');
        $this->logger->debug($exception);
        $this->logger->debug('### EXCEPTION LANÇADA END ###');
    }

    public function solicitarChaveFinalizou(): void
    {
        $this->logger->debug('### EXECUÇÃO FINALIZADA ###');
    }
}
