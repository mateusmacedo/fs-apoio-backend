<?php

namespace App\Listeners\Import;

use App\Events\Storage\PresaleClientesFileStoraged;
use App\Jobs\Imports\PresaleClienteImport;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;
use Maatwebsite\Excel\Importer;

class TriggerPresaleImport
{
    /**
     * @var Importer
     */
    private $importer;
    /**
     * @var ListenerLoggerInterface
     */
    private $logger;

    public function __construct(ListenerLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param PresaleClientesFileStoraged $event
     * @return void
     */
    public function handle(PresaleClientesFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $filename = $event->getfilename();
            $this->logger->listenerDisparado(static::class, 'App\Jobs\PresaleClienteImport:' . $filename);
            PresaleClienteImport::dispatch($filename);
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }
}
