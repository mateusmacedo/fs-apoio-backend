<?php

namespace App\Jobs;

use App\Services\Application\Http\Factories\SolicitarChaveFactory;
use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SolicitarChave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var array
     */
    private $body;
    /**
     * @var Application|App\Services\Application\Loggers\Interfaces\JobsLoggerInterface
     */
    private $logger;
    private $queueRetry = 'solicitar-chave-retry';
    public $tries = 3;

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
     * @todo tratar response diferente de 200
     */
    public function handle(WebConsumerInterface $webConsumer)
    {
        try {
            $this->logger->jobIniciado(__METHOD__, json_encode($this->body));
            $payload = SolicitarChaveFactory::create(collect($this->body));
            $result = $webConsumer->fetch($payload);
            $this->logger->jobRealizado($payload);
        } catch (Exception $exception) {
            $this->logger->jobFalhou($exception);
            SolicitarChave::dispatch($this->body)->onQueue($this->queueRetry);
            $this->logger->jobRedirecionado($this->queueRetry);
            $this->delete();
        } finally {
            $this->logger->jobFinalizado();
        }
    }
}
