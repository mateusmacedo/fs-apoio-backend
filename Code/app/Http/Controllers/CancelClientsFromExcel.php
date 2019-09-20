<?php

namespace App\Http\Controllers;

use App\Services\Domain\ClientDomainServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CancelClientsFromExcel extends Controller
{
    /**
     * @var ClientDomainServiceInterface
     */
    private $domainService;

    public function __construct(ClientDomainServiceInterface $domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $result = $this->domainService->cancelarChavesFromFile($request->file('file'));
        return new Response($result->getContent(), $result->getStatusCode());
    }
}
