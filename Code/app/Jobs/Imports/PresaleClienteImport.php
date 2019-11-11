<?php

namespace App\Jobs\Imports;

use App\Imports\PresaleClientesImport;
use App\Services\Application\Loggers\Interfaces\JobsLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Importer;

class PresaleClienteImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $filename;
    /**
     * @var JobsLoggerInterface
     */
    private $logger;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->queue = env('PRESALE_SUBSCRIPTION_QUEUE_IMPORT');
    }

    /**
     * Execute the job.
     *
     * @param Importer $importer
     * @param JobsLoggerInterface $logger
     * @return void
     */
    public function handle(Importer $importer, JobsLoggerInterface $logger): void
    {
        $this->logger = $logger;
        try {
            $this->logger->jobIniciado(__METHOD__, $this->getFile()->getFilename());
            $importer->import(
                app(PresaleClientesImport::class),
                $this->getFile()
            );
            $this->logger->jobRealizado('true');
        } catch (Exception $exception) {
            $this->logger->jobFalhou($exception);
            $this->retryHandle();
        } finally {
            $this->logger->jobFinalizado();
        }
    }

    /**
     * @return File
     */
    private function getFile(): File
    {
        $storageService = app(StorageServiceInterface::class);
        $storageService->setBasePath(env('FILESYSTEM_PRESALE_SUBSCRIPTION_FROM_FILE'));
        return $storageService->getFile($this->filename);
    }

    /**
     *
     */
    private function retryHandle(): void
    {
        $queueRetry = $this->queue . ':retry';
        SubscriptionClienteImport::dispatch($this->filename)
            ->onQueue($queueRetry);
        $this->delete();
        $this->logger->jobRedirecionado($queueRetry);
    }
}
