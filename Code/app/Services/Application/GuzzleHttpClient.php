<?php


namespace App\Services\Application;


use App\Services\Application\Interfaces\ClientInterface;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements ClientInterface
{

    /**
     * @var GuzzleClientInterface
     */
    private $client;

    /**
     * GuzzleHttpClient constructor.
     * @param GuzzleClientInterface $client
     */
    public function __construct(GuzzleClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request);
    }
}
