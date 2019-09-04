<?php

namespace App\Http\Controllers;

use App\Services\Application\Factories\SolicitarChaveFactory;
use App\Services\Application\Interfaces\SolicitarChaveLoggerInterface;
use App\Services\Application\Interfaces\WebConsumerInterface;
use App\Services\Application\Loggers\SolicitarChaveLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SolicitarChaveController extends Controller
{
    /**
     * @var WebConsumerInterface
     */
    private $webConsumer;
    /**
     * @var SolicitarChaveLogger
     */
    private $logger;

    /**
     * SolicitarChaveController constructor.
     * @param WebConsumerInterface $webConsumer
     * @param SolicitarChaveLoggerInterface $logger
     */
    public function __construct(WebConsumerInterface $webConsumer, SolicitarChaveLoggerInterface $logger)
    {
        $this->webConsumer = $webConsumer;
        $this->logger = $logger;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            $this->logger->solicitarChaveIniciada($request->all());
            $payload = SolicitarChaveFactory::create($request->all());
            $result = $this->webConsumer->fetch($payload);
            $this->logger->solicitarChaveRealizada($result);
            return $result;
        } catch (Exception $exception) {
            $this->logger->solicitarChaveFalhou($exception);
        } finally {
            $this->logger->solicitarChaveFinalizou();
        }
        return response()->json([], 401);
    }
}
