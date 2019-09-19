<?php


namespace App\Services\Application\Http;


use App\Services\Application\Http\Interfaces\ClientInterface;
use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Interfaces\RequestFactoryInterface;
use App\Services\Application\Http\Interfaces\WebConsumerInterface;
use App\Services\Application\Loggers\Interfaces\WebConsumerLoggerInterface;
use Exception;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class WebConsumer implements WebConsumerInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;
    /**
     * @var RequestFactoryInterface
     */
    private $httpRequestFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $httpRequestFactory, WebConsumerLoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
        $this->logger = $logger;
    }

    /**
     * @param PayloadInterface $payload
     * @return Response
     */
    public function fetch(PayloadInterface $payload): Response
    {
        try {
            $this->logger->requestIniciada($payload);
            $request = $this->httpRequestFactory->createRequest($payload);
            $response = $this->httpClient->sendRequest($request);
            $statusCode = $response->getStatusCode();
            $headers = $response->getHeaders();
            $contents = $response->getBody()->getContents();
            $this->logger->requestRealizada($statusCode, $headers, $contents);
            return new Response($contents, $statusCode);
        } catch (Exception $exception) {
            $this->logger->requestFalhou($exception);
            return new Response($exception->getMessage(), 500);
        } finally {
            $this->logger->requestFinalizou();
        }
    }
}
