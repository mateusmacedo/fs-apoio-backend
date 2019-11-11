<?php


namespace App\Services\Application\Http\Payloads\Presale;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Traits\DataTransformer;
use stdClass;

class Subscription implements PayloadInterface
{
    use DataTransformer;
    /**
     * @var stdClass
     */
    private $params;

    public function __construct(stdClass $params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $body = json_decode($this->getBody());
        return (string)json_encode([
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'headers' => $this->getHeaders(),
            'body' => $body
        ]);
    }

    public function getBody(): string
    {
        $payloadParams = [
            'campaign' => $this->params->campaign,
            'subscription_id' => $this->params->subscriptionId,
            'user' => [
                'email' => $this->params->userEmail,
                'msisdn' => $this->params->userMsisdn,
            ],
        ];
        return json_encode($payloadParams);
    }

    public function getUri(): string
    {
        return 'http://' . env('PRESALE_PARTER_API') . '/' . trim($this->params->partnerName) . '/v1/subscription';
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
