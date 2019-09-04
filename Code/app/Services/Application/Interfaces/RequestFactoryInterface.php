<?php


namespace App\Services\Application\Interfaces;


use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    /**
     * @param PayloadInterface $payload
     * @return RequestInterface
     */
    public function createRequest(PayloadInterface $payload): RequestInterface;
}
