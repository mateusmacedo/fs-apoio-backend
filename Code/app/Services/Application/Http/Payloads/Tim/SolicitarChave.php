<?php


namespace App\Services\Application\Http\Payloads\Tim;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Traits\DataTransformer;
use stdClass;

class SolicitarChave implements PayloadInterface
{
    use DataTransformer;
    /**
     * @var stdClass
     */
    private $params;

    /**
     * SolicitarChave constructor.
     * @param stdClass $params
     */
    public function __construct(stdClass $params)
    {
        $this->params = $params;
    }

    public function __toString(): string
    {
        $body = json_decode($this->getBody());
        return json_encode([
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'headers' => $this->getHeaders(),
            'body' => $body
        ]);
    }

    public function getUri(): string
    {
        return 'http://' . env('TIM_BACKEND_URL') . '/api/fluxo-assinatura-interna.php';
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

    public function getBody(): string
    {
        $payloadParams = $this->objectToArray($this->params);
        return json_encode($payloadParams);
    }
}
