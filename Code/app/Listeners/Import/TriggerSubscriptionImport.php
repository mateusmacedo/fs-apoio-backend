<?php

namespace App\Listeners\Import;

use App\Events\Storage\SubscriptionClientesFileStoraged;
use App\Jobs\SubscriptionClienteImport;
use App\Services\Application\Loggers\Interfaces\ListenerLoggerInterface;
use Exception;
use Maatwebsite\Excel\Importer;

class TriggerSubscriptionImport
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
     * @param SubscriptionClientesFileStoraged $event
     * @return void
     */
    public function handle(SubscriptionClientesFileStoraged $event)
    {
        try {
            $event->getLogger()->listenerIniciado(static::class);
            $filename = $event->getfilename();
            $this->logger->listenerDisparado(static::class, 'App\Jobs\SubscriptionClienteImport:' . $filename);
            SubscriptionClienteImport::dispatch($filename);
            $this->logger->listenerRealizado('true');
        } catch (Exception $exception) {
            $this->logger->listenerFalhou($exception);
        } finally {
            $this->logger->listenerFinalizado();
        }
    }
}
