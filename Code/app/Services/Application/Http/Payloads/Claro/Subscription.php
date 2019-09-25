<?php


namespace App\Services\Application\Http\Payloads\Claro;


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

    /**
     * Subscription constructor.
     * @param stdClass $params
     */
    public function __construct(stdClass $params)
    {

        $this->params = $params;
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
        $payloadParams = $this->objectToArray($this->params);
        return json_encode($payloadParams);
    }
}
