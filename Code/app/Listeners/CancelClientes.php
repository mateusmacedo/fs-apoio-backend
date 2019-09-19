<?php

namespace App\Listeners;

use App\Events\CancelarChaveFileStoraged;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Importer;

class CancelClientes implements ShouldQueue
{
    public $connection = 'rabbitmq';
    public $queue = 'cancel-base-clientes';
    public $timeout = 0;
    public $tries = 3;
    /**
     * @var Importer
     */
    private $importer;
    /**
     * @var ListenerLoggerInterface
     */
    private $logger;

    public function __construct(Importer $importer, ListenerLoggerInterface $logger)
    {
        $this->importer = $importer;
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param CancelarChaveFileStoraged $event
     * @return void
     * @todo  Definir o fluxo de exception
     */
    public function handle(CancelarChaveFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $this->logger->listenerDisparado(static::class, 'App\Imports\CancelarChaveImport:' . $event->getfilename());
            $this->importer->import(
                app('App\Imports\CancelarChaveImport'),
                $event->getFile()
            );
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }

    public function failed(Exception $exception)
    {
        $this->logger->listenerFalhou($exception);
    }
}
