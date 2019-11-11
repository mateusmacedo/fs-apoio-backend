<?php

namespace App\Events\Storage;

use App\Services\Application\Loggers\Interfaces\EventLoggerInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresaleClientesFileStoraged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var void
     */
    private $logger;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->logger = app(EventLoggerInterface::class);
        $this->logger->eventoDisparado(static::class, $filename);
    }

    public function getLogger(): EventLoggerInterface
    {
        return $this->logger;
    }

    public function getfilename(): string
    {
        $this->logger->metodoExecutado(__METHOD__, func_get_args());
        return $this->filename;
    }
}
