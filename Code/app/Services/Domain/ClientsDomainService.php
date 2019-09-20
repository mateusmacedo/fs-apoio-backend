<?php


namespace App\Services\Domain;


use App\Events\CancelarChaveFileStoraged;
use App\Events\SolicitarChaveFileStoraged;
use App\Services\Application\Loggers\Interfaces\DomainLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface;
use App\Traits\CollectExecutionData;
use Exception;
use Illuminate\Http\Response;
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
        $this->logger = $logger;
    }

    /**
     * @param UploadedFile $file
     * @return Response
     * @todo analisar melhor o ponto de lançamento do evento
     * @todo Criar teste
     */
    public function solicitarChavesFromFile(UploadedFile $file): Response
    {
        try {
            $this->logger->operacaoIniciada($this->getMethodData(__METHOD__, func_get_args()));
            $this->storageService->setBasePath(env('FILESYSTEM_IMPORT_FROM_FILE'));
            $filePathStored = $this->storageService->store($this->generateFilename($file, 'SolicitarChave'), $file);
            event(new SolicitarChaveFileStoraged($filePathStored));
            $this->logger->operacaoRealizada($this->getResultData($filePathStored));
            return new Response(['Success'], 200);
        } catch (Exception $exception) {
            $this->logger->operacaoFalhou($exception);
        } finally {
            $this->logger->operacaoFinalizou();
        }
        return new Response(['Fail'], 500);
    }


    /**
     * @param UploadedFile $file
     * @return Response
     * @todo criar teste
     */
    public function cancelarChavesFromFile(UploadedFile $file)
    {
        try {
            $this->logger->operacaoIniciada($this->getMethodData(__METHOD__, func_get_args()));
            $this->storageService->setBasePath(env('FILESYSTEM_CANCEL_FROM_FILE'));
            $filePathStored = $this->storageService->store($this->generateFilename($file, 'CancelarChave'), $file);
            event(new CancelarChaveFileStoraged($filePathStored));
            $this->logger->operacaoRealizada($this->getResultData($filePathStored));
            return new Response(['Success'], 200);
        } catch (Exception $exception) {
            $this->logger->operacaoFalhou($exception);
        } finally {
            $this->logger->operacaoFinalizou();
        }
        return new Response(['Fail'], 500);
    }

    /**
     * @param UploadedFile $file
     * @param string $prefix
     * @return string
     * @todo criar teste
     */
    private function generateFilename(UploadedFile $file, string $prefix): string
    {
        return $prefix . date('dmYHis') . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @param string $filePathStored
     * @return array
     * @todo criar teste
     */
    private function getResultData(string $filePathStored): array
    {
        return [
            'fileUrl' => $this->storageService->getUrl($filePathStored),
            'eventDispatch' => SolicitarChaveFileStoraged::class
        ];
    }

}
