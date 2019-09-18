<?php

namespace App\Imports;

use App\Jobs\SolicitarChave;
use App\Services\Application\Loggers\Interfaces\ImporterLoggerInterface;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Psr\Log\LoggerInterface;
use RuntimeException;

class SolicitarChaveImport implements ToCollection, WithHeadingRow, WithChunkReading, WithCalculatedFormulas
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    private $collection;
    private $row;

    /**
     * BatimentoBaseImport constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(ImporterLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        try {
            $this->logger->ImportacaoIniciada();
            $this->logger->collectionRecebida($collection);
            $this->collection = $collection;
            $job = $this;
            $collection->each(static function ($row) use ($job) {
                $job->row = $row;
                SolicitarChave::dispatch($row->all())
                    ->onConnection('rabbitmq')
                    ->onQueue('solicitar-chave');
            });
        } catch (Exception $exception) {
            $this->logger->importacaoFalhou($exception, $this->collection, $this->row);
            throw new RuntimeException($exception->getMessage());
        } finally {
            $this->logger->importacaoFinalizada();
        }
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }
}
