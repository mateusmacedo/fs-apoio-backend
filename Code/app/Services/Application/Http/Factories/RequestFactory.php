<?php


namespace App\Services\Application\Http\Factories;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Interfaces\RequestFactoryInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    public function createRequest(PayloadInterface $payload): RequestInterface
    {
        return new Request(
            $payload->getMethod(),
            $payload->getUri(),
            $payload->getHeaders(),
            $payload->getBody()
        );
    }
}
