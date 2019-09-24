<?php

namespace App\Listeners\Import;

use App\Events\Storage\SolicitarChaveFileStoraged;
use App\Jobs\Imports\SolicitarChaveImport;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;

class TriggerSolicitarChaveImport
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
     * @param SolicitarChaveFileStoraged $event
     * @return void
     */
    public function handle(SolicitarChaveFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $filename = $event->getfilename();
            $this->logger->listenerDisparado(static::class, 'App\Jobs\CancelarChaveImport:' . $filename);
            SolicitarChaveImport::dispatch($filename);
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }
}
