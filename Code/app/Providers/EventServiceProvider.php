<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Storage\SolicitarChaveFileStoraged' => [
            'App\Listeners\Import\TriggerSolicitarChaveImport'
        ],
        'App\Events\Storage\CancelarChaveFileStoraged' => [
            'App\Listeners\Import\TriggerCancelarChaveImport'
        ],
        'App\Events\Storage\SubscriptionClientesFileStoraged' => [
            'App\Listeners\Import\TriggerSubscriptionImport'
        ],
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
