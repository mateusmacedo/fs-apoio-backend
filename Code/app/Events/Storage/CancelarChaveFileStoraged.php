<?php

namespace App\Events\Storage;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelarChaveFileStoraged
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
        $this->logger = app('App\Services\Application\Loggers\Interfaces\EventLoggerInterface');
        $this->logger->eventoDisparado(static::class, $filename);
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function getfilename()
    {
        $this->logger->metodoExecutado(__METHOD__, func_get_args());
        return $this->filename;
    }
}
