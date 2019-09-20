<?php


namespace App\Services\Application\Http\Payloads\Tim;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use stdClass;

class SolicitarChave implements PayloadInterface
{
    /**
     * @var string
     */
    private $msisdn;
    /**
     * @var string
     */
    private $subscriptionId;
    /**
     * @var int
     */
    private $ppId;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $nome;
    /**
     * @var string
     */
    private $transactionOptions;
    /**
     * @var string
     */
    private $vendedor;
    /**
     * @var string
     */
    private $campanha;
    /**
     * @var string
     */
    private $biAcao;
    /**
     * @var string
     */
    private $canal;
    /**
     * @var bool
     */
    private $silent;

    public function __construct(stdClass $params)
    {
        $this->msisdn = (string)$params->msisdn;
        $this->subscriptionId = $params->subscriptionId;
        $this->ppId = $params->ppId;
        $this->email = $params->email;
        $this->nome = $params->nome;
        $this->transactionOptions = $params->transactionOptions;
        $this->vendedor = $params->vendedor;
        $this->campanha = $params->campanha;
        $this->biAcao = $params->biAcao;
        $this->canal = $params->canal;
        $this->silent = $params->silent;
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
        return json_encode([
            'msisdn' => $this->msisdn,
            'subscriptionId' => $this->subscriptionId,
            'ppId' => $this->ppId,
            'email' => $this->email,
            'nome' => $this->nome,
            'transactionOptions' => $this->transactionOptions,
            'vendedor' => $this->vendedor,
            'campanha' => $this->campanha,
            'biAcao' => $this->biAcao,
            'canal' => $this->canal,
            'silent' => $this->silent
        ]);
    }
}
