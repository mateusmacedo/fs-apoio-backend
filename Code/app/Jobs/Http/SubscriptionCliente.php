<?php

namespace App\Jobs\Http;

use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use App\Services\Application\Http\Payloads\Factories\SubscriptionPaylodFactory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class SubscriptionCliente implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries;
    private $body;
    private $logger;
    private $timeout;

    public function __construct(array $body)
    {
        $this->body = $body;
        $this->logger = app('App\Services\Application\Loggers\Interfaces\JobsLoggerInterface');
        $this->queue = env('SUBSCRIPTION_CLIENTES_QUEUE');
        $this->timeout = env('SUBSCRIPTION_CLIENTES_QUEUE_TIMEOUT');
        $this->tries = env('SUBSCRIPTION_CLIENTES_QUEUE_TRIES');
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
            $payload = SubscriptionPaylodFactory::create(collect($this->body));
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
        $queueRetry = $this->queue . 'retry';
        SubscriptionCliente::dispatch($this->body)->onQueue($queueRetry);
        $this->logger->jobRedirecionado($queueRetry);
        $this->delete();
    }

    public function failed(Exception $exception)
    {
        $this->logger->jobFalhou($exception);
        $this->retryHandle();
    }
}
