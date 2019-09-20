<?php


namespace App\Services\Application\Http\Payloads\Tim;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use stdClass;

class CancelarChave implements PayloadInterface
{
    public function __construct(stdClass $params)
    {
        $this->chave = $params->chave;
        $this->motivo = $params->motivo;
        $this->vendedor = $params->vendedor;
        $this->silent = $params->silent;
        $this->clientCorrelator = $params->clientCorrelator;
        $this->biAcao = $params->biAcao;
        $this->canalCancelamento = $params->canalCancelamento;
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
            'chave' => $this->chave,
            'motivo' => $this->motivo,
            'vendedor' => $this->vendedor,
            'silent' => $this->silent,
            'clientCorrelator' => $this->clientCorrelator,
            'biAcao' => $this->biAcao,
            'canalCancelamento' => $this->canalCancelamento
        ]);
    }

    public function getUri(): string
    {
        return 'http://' . env('TIM_BACKEND_URL') . '/api/fluxo-assinatura-interna.php';
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
