<?php


namespace App\Services\Application;


use App\Services\Application\Interfaces\ClientInterface;
use App\Services\Application\Interfaces\PayloadInterface;
use App\Services\Application\Interfaces\RequestFactoryInterface;
use App\Services\Application\Interfaces\WebConsumerInterface;
use App\Services\Application\Interfaces\WebConsumerLoggerInterface;
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
            return response($contents, $statusCode);
        } catch (Exception $exception) {
            $this->logger->requestFalhou($exception);
        } finally {
            $this->logger->requestFinalizou();
        }

        return response()->json([], 401);
    }
}
