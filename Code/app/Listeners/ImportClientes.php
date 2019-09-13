<?php

namespace App\Listeners;

use App\Events\SolicitarChaveFileStoraged;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Importer;

class ImportClientes implements ShouldQueue
{
    public $connection = 'rabbitmq';
    public $queue = 'imports-base-clientes';
    public $timeout = 0;
    public $tries = 1;
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
     * @param SolicitarChaveFileStoraged $event
     * @return void
     * @todo  Definir o fluxo de exception
     */
    public function handle(SolicitarChaveFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $this->logger->listenerDisparado(static::class, 'App\Imports\SolicitarChaveImport:' . $event->getfilename());
            $this->importer->import(
                app('App\Imports\SolicitarChaveImport'),
                $event->getFile()
            );
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }
}
