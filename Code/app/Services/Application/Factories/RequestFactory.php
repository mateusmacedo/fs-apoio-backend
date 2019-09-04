<?php


namespace App\Services\Application\Factories;


use App\Services\Application\Interfaces\PayloadInterface;
use App\Services\Application\Interfaces\RequestFactoryInterface;
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
            http_build_query($payload->getBody(), null, '&')
        );
    }
}
