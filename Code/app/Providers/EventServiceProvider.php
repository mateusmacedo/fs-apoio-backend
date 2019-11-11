<?php

namespace App\Providers;

use App\Events\Storage\CancelarChaveFileStoraged;
use App\Events\Storage\PresaleClientesFileStoraged;
use App\Events\Storage\SolicitarChaveFileStoraged;
use App\Events\Storage\SubscriptionClientesFileStoraged;
use App\Listeners\Import\TriggerCancelarChaveImport;
use App\Listeners\Import\TriggerPresaleImport;
use App\Listeners\Import\TriggerSolicitarChaveImport;
use App\Listeners\Import\TriggerSubscriptionImport;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SolicitarChaveFileStoraged::class => [
            TriggerSolicitarChaveImport::class
        ],
        CancelarChaveFileStoraged::class => [
            TriggerCancelarChaveImport::class
        ],
        SubscriptionClientesFileStoraged::class => [
            TriggerSubscriptionImport::class
        ],
        PresaleClientesFileStoraged::class => [
            TriggerPresaleImport::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
