<?php


namespace App\Services\Infrastructure\Storage;


use App\Exceptions\StorageException;
use App\Services\Application\Loggers\Interfaces\StorageLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class AbstractStorageService implements StorageServiceInterface
{
    protected $disk;
    protected $basePath;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(StorageLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $basePath
     * @return AbstractStorageService
     * @todo setBasePathTestCase
     */
    public function setBasePath(string $basePath): AbstractStorageService
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * @param $filename
     * @return string
     * @throws StorageException
     * @todo getFilePathTestCase
     */
    public function getFilePath($filename)
    {
        if (empty($this->basePath)) {
            throw new StorageException(StorageException::BASE_PATH_NOT_FOUND);
        }
        return $this->basePath . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * @param string $filename
     * @param UploadedFile $file
     * @return string
     * @throws StorageException
     * @todo storeTestCase
     */
    public function store(string $filename, UploadedFile $file): string
    {
        try {
            if (empty($this->basePath)) {
                throw new StorageException(StorageException::BASE_PATH_NOT_FOUND);
            }
            $this->logger->storageIniciado($file);
            $result = (string)Storage::disk($this->disk)->putFileAs($this->basePath, $file, $filename);
            $this->logger->storageRealizado($result);
            return $filename;
        } catch (Exception $exception) {
            $this->logger->storageFalhou($exception);
            throw new StorageException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            $this->logger->storageFinalizado();
        }
    }

    /**
     * @param string $filename
     * @return bool
     * @throws StorageException
     * @todo deleteTestCase
     */
    public function delete(string $filename): bool
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new StorageException(StorageException::NOT_FOUND);
            }
            //logger iniciou
            Storage::disk($this->disk)->delete($path);
            //logger deletou
            return true;
        } catch (Exception $exception) {
            //logger falhou
            throw new StorageException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            //logger finalizou
        }
    }

    /**
     * @param $filename
     * @return string
     * @throws StorageException
     * @todo getUrlTestCase
     */
    public function getUrl($filename): string
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new StorageException(StorageException::NOT_FOUND);
            }
            //logger iniciou
            $url = Storage::disk($this->disk)->url($path);
            //logger executou
            return $url;
        } catch (Exception $exception) {
            //logger falhou
            throw new StorageException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            //logger finalizou
        }
    }

    /**
     * @param $filename
     * @return ResponseInterface
     * @throws StorageException
     * @todo downloadTestCase
     */
    public function download($filename): StreamedResponse
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new StorageException(StorageException::NOT_FOUND);
            }
            //logger iniciou
            return Storage::disk($this->disk)->download($path);
        } catch (Exception $exception) {
            //logger falhou
            throw new StorageException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            //logger finalizou
        }
    }
}
