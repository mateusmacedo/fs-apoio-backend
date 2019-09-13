<?php


namespace App\Services\Application\Http\Payloads\Tim;


use App\Services\Application\Http\Interfaces\PayloadInterface;

class SolicitarChave implements PayloadInterface
{
    public function __construct()
    {

    }

    public function __toString(): string
    {
        return json_encode();
    }

    public function getUri(): string
    {
        return 'http://' . env('TIM_BACKEND_URL', '172.18.0.4') . '/api/fluxo-assinatura-interna.php';
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

    public function getBody(): array
    {
        return [
        ];
    }
}
