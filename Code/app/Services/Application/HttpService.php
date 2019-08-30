<?php


namespace App\Services\Application;

use App\Services\Application\Interfaces\HttpService as HttpServiceInterface;

abstract class HttpService implements HttpServiceInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
