<?php

namespace App\Listeners\Import;

use App\Events\Storage\CancelarChaveFileStoraged;
use App\Jobs\Imports\CancelarChaveImport;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;

class TriggerCancelarChaveImport
{
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
     * @param CancelarChaveFileStoraged $event
     * @return void
     */
    public function handle(CancelarChaveFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $filename = $event->getfilename();
            $this->logger->listenerDisparado(static::class, 'App\Jobs\CancelarChaveImport:' . $filename);
            CancelarChaveImport::dispatch($filename);
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }
}
