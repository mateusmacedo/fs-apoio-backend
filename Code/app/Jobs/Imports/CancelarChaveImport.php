<?php

namespace App\Jobs\Imports;

use App\Services\Application\Loggers\Interfaces\JobsLoggerInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Importer;

class CancelarChaveImport implements ShouldQueue
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
        $this->queue = env('CANCELAR_CHAVE_QUEUE_IMPORT');
    }

    /**
     * Execute the job.
     *
     * @param Importer $importer
     * @param JobsLoggerInterface $logger
     * @return void
     */
    public function handle(Importer $importer, JobsLoggerInterface $logger)
    {
        $this->logger = $logger;
        try {
            $this->logger->jobIniciado(__METHOD__, $this->getFile()->getFilename());
            $importer->import(
                app('App\Imports\CancelarChaveImport'),
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

    private function getFile(): File
    {
        $storageService = app('App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface');
        $storageService->setBasePath(env('FILESYSTEM_CANCEL_FROM_FILE'));
        return $storageService->getFile($this->filename);
    }

    private function retryHandle()
    {
        $queueRetry = $this->queue . ':retry';
        CancelarChaveImport::dispatch($this->filename)
            ->onQueue($queueRetry);
        $this->delete();
        $this->logger->jobRedirecionado($queueRetry);
    }
}
