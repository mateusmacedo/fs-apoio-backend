<?php


namespace App\Services\Domain;


use App\Events\SolicitarChaveFileStoraged;
use App\Services\Application\Loggers\Interfaces\DomainLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface;
use App\Traits\CollectExecutionData;
use Exception;
use Illuminate\Http\UploadedFile;

class ClientsDomainService implements ClientDomainServiceInterface
{
    use CollectExecutionData;
    /**
     * @var StorageServiceInterface
     */
    private $storageService;
    /**
     * @var DomainLoggerInterface
     */
    private $logger;

    /**
     * ClientsDomainService constructor.
     * @param StorageServiceInterface $storageService
     * @param DomainLoggerInterface $logger
     */
    public function __construct(StorageServiceInterface $storageService, DomainLoggerInterface $logger)
    {
        $this->storageService = $storageService;
        $this->storageService->setBasePath(env('FILESYSTEM_IMPORT_CLIENTES'));
        $this->logger = $logger;
    }

    /**
     * @param UploadedFile $file
     * @todo analisar melhor o ponto de lançamento do evento
     */
    public function solicitarChavesFromFile(UploadedFile $file)
    {
        try {
            $this->logger->operacaoIniciada($this->getMethodData(__METHOD__, func_get_args()));
            $filePathStored = $this->storageService->store($this->generateFilename($file), $file);
            event(new SolicitarChaveFileStoraged($filePathStored));
            $this->logger->operacaoRealizada($this->getResultData($filePathStored));
        } catch (Exception $exception) {
            $this->logger->operacaoFalhou($exception);
        } finally {
            $this->logger->operacaoFinalizou();
        }
    }

    private function generateFilename(UploadedFile $file)
    {
        return 'SolicitarChave' . date('dmYHis') . '.' . $file->getClientOriginalExtension();
    }

    private function getResultData(string $filePathStored)
    {
        return [
            'fileUrl' => $this->storageService->getUrl($filePathStored),
            'eventDispatch' => SolicitarChaveFileStoraged::class
        ];
    }

}
