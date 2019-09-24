<?php


namespace App\Services\Application\Http\Payloads\Claro;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use stdClass;

class Subscription implements PayloadInterface
{

    private $silent;
    private $identifier;
    private $la;
    private $partner;
    private $reason;
    private $canceler;
    private $action;
    private $subscriptionId;

    public function __construct(stdClass $params)
    {
        $this->silent = $params->silent;
        $this->identifier = $params->identifier;
        $this->la = $params->la;
        $this->partner = $params->partner;
        $this->reason = $params->reason;
        $this->canceler = $params->canceler;
        $this->action = $params->action;
        $this->subscriptionId = $params->subscriptionId;
    }

    public function __toString(): string
    {
        return json_encode([
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'headers' => $this->getHeaders(),
            'body' => $this->getBody()
        ]);
    }

    public function getUri(): string
    {
        return 'http://' . env('CLARO_BACKEND_URL') . '/v1/main/subscribe';
    }

    public function getMethod(): string
    {
        return 'PATCH';
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getBody(): string
    {
        return json_encode([
            'silent' => $this->silent,
            'identifier' => $this->identifier,
            'la' => $this->la,
            'partner' => $this->partner,
            'reason' => $this->reason,
            'canceler' => $this->canceler,
            'action' => $this->action,
            'subscriptionId' => $this->subscriptionId
        ]);
    }
}
