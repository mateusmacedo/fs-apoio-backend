<?php

namespace App\Jobs;

use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use App\Services\Application\Http\Payloads\Factories\CancelarChavePaylodFactory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class CancelarChave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    /**
     * @var array
     */
    private $body;
    /**
     * @var Application|App\Services\Application\Loggers\Interfaces\JobsLoggerInterface
     */
    private $logger;
    private $queueRetry = 'cancelar-chave-retry';

    /**
     * SolicitarChave constructor.
     * @param array $body
     */
    public function __construct(array $body)
    {
        $this->body = $body;
        $this->logger = app('App\Services\Application\Loggers\Interfaces\JobsLoggerInterface');
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
            $payload = CancelarChavePaylodFactory::create(collect($this->body));
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

    private function responseHandle(Response $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException($response->getContent());
        }
    }

    private function retryHandle()
    {
        SolicitarChave::dispatch($this->body)->onQueue($this->queueRetry);
        $this->logger->jobRedirecionado($this->queueRetry);
        $this->delete();
    }
}
