<?php


namespace App\Services\Infrastructure\Storage;


use App\Services\Application\Loggers\Interfaces\StorageLoggerInterface;
use App\Services\Infrastructure\Storage\Interfaces\StorageServiceInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use SplFileInfo;
use Storage;

abstract class AbstractStorageService implements StorageServiceInterface
{
    public const BASE_PATH_NOT_FOUND = 'BasePath não definido para o serviço';
    public const NOT_FOUND = 'Arquivo não existe no armazenamento';
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
     * @param string $filename
     * @param SplFileInfo $file
     * @return string
     * @todo storeTestCase
     */
    public function store(string $filename, UploadedFile $file): string
    {
        try {
            if (empty($this->basePath)) {
                throw new RuntimeException(self::BASE_PATH_NOT_FOUND);
            }
            $this->logger->storageIniciado($file);
            $result = (string)Storage::disk($this->disk)->putFileAs($this->basePath, $file, $filename);
            $this->logger->storageRealizado($result);
            return $filename;
        } catch (Exception $exception) {
            $this->logger->storageFalhou($exception);
            throw new RuntimeException($exception->getMessage());
        } finally {
            $this->logger->storageFinalizado();
        }
    }

    /**
     * @param string $filename
     * @return bool
     * @todo deleteTestCase
     */
    public function delete(string $filename): bool
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new RuntimeException(self::NOT_FOUND);
            }
            //logger iniciou
            Storage::disk($this->disk)->delete($path);
            //logger deletou
            return true;
        } catch (Exception $exception) {
            //logger falhou
            throw new RuntimeException($exception->getMessage());
        } finally {
            //logger finalizou
        }
    }

    /**
     * @param $filename
     * @return string
     * @todo getFilePathTestCase
     */
    public function getFilePath($filename)
    {
        if (empty($this->basePath)) {
            throw new RuntimeException(self::BASE_PATH_NOT_FOUND);
        }
        return $this->basePath . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * @param $filename
     * @return string
     * @todo getUrlTestCase
     */
    public function getUrl($filename): string
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new RuntimeException(self::NOT_FOUND);
            }
            //logger iniciou
            $url = Storage::disk($this->disk)->url($path);
            //logger executou
            return $url;
        } catch (Exception $exception) {
            //logger falhou
            throw new RuntimeException($exception->getMessage());
        } finally {
            //logger finalizou
        }
    }

    /**
     * @param $filename
     * @return ResponseInterface
     * @todo downloadTestCase
     */
    public function download($filename): ResponseInterface
    {
        try {
            $path = $this->getFilePath($filename);
            if (!Storage::disk($this->disk)->exists($path)) {
                throw new RuntimeException(self::NOT_FOUND);
            }
            //logger iniciou
            return Storage::disk($this->disk)->download($path);
        } catch (Exception $exception) {
            //logger falhou
            throw new RuntimeException($exception->getMessage());
        } finally {
            //logger finalizou
        }
    }
}
