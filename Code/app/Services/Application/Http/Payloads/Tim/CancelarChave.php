<?php


namespace App\Services\Application\Http\Payloads\Tim;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use stdClass;

class CancelarChave implements PayloadInterface
{
    public function __construct(stdClass $params)
    {
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

    public function getBody(): string
    {
        return json_encode([

        ]);
    }

    public function getUri(): string
    {
        return 'http://' . env('TIM_BACKEND_URL', 'tim-backend') . '/api/fluxo-assinatura-interna.php';
    }

    public function getMethod(): string
    {
        return 'DELETE';
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
