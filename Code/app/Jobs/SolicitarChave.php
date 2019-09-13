<?php

namespace App\Jobs;

use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;
use stdClass;

class SolicitarChave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var Application|App\Services\Application\Loggers\Interfaces\JobsLoggerInterface
     */
    private $logger;
    private $queueRetry = 'solicitar-chave-retry';

    /**
     * Create a new job instance.
     *
     * @param stdClass $msg
     */
    public function __construct(stdClass $msg)
    {
        $this->connection = 'rabbitmq';
        $this->queue = 'solicitar-chave';
        $this->msg = $msg;
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
            $this->logger->jobIniciado(__METHOD__, json_encode($this->msg));
            if (rand(0, 10) % 2 === 1) {
                throw new RuntimeException('TESTE DE FALHA');
            }
//            $payload = SolicitarChaveFactory::create($this->msg);
//            $result = $webConsumer->fetch($payload);
//            $this->logger->jobRealizado($result->getContent());
        } catch (Exception $exception) {
            $this->logger->jobFalhou($exception);
            SolicitarChave::dispatch($this->msg)->onQueue($this->queueRetry);
            $this->logger->jobRedirecionado($this->queueRetry);
            $this->delete();
        } finally {
            $this->logger->jobFinalizado();
        }
    }
}
