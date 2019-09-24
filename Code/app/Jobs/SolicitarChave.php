<?php

namespace App\Jobs;

use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use App\Services\Application\Http\Payloads\Factories\SolicitarChavePaylodFactory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class SolicitarChave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $body;
    private $logger;
    public $tries;
    public $timeout;

    public function __construct(array $body)
    {
        $this->body = $body;
        $this->logger = app('App\Services\Application\Loggers\Interfaces\JobsLoggerInterface');
        $this->queue = env('SOLICITAR_CHAVE_QUEUE');
        $this->timeout = env('SOLICITAR_CHAVE_QUEUE_TIMEOUT');
        $this->tries = env('SOLICITAR_CHAVE_QUEUE_TRIES');
    }

    /**
     * Execute the job.
     *
     * @param WebConsumerInterface $webConsumer
     * @return void
     */
    public function handle(WebConsumerInterface $webConsumer)
    {
        try {
            $this->logger->jobIniciado(__METHOD__, json_encode($this->body));
            $payload = SolicitarChavePaylodFactory::create(collect($this->body));
            $result = $webConsumer->fetch($payload);
            $this->responseHandle($result);
            $this->logger->jobRealizado($result->getContent());
        } catch (Exception $exception) {
            $this->logger->jobFalhou($exception);
            $this->retryHandle();
        } finally {
            $this->logger->jobFinalizado();
        }
    }

    public function failed(Exception $exception)
    {
        $this->logger->jobFalhou($exception);
        $this->retryHandle();
    }

    private function responseHandle(Response $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException($response->getContent());
        }
    }

    private function retryHandle()
    {
        $retryQueue = $this->queue . '-retry';
        SolicitarChave::dispatch($this->body)->onQueue($retryQueue);
        $this->logger->jobRedirecionado($retryQueue);
        $this->delete();
    }
}
