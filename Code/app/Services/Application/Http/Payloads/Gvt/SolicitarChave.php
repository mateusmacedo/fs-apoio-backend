<?php


namespace App\Services\Application\Http\Payloads\Gvt;


use App\Services\Application\Http\Interfaces\PayloadInterface;

class SolicitarChave implements PayloadInterface
{
    /**
     * @var string
     */
    private $msisdn;
    /**
     * @var string
     */
    private $cpf;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $purchaseOrderNumber;
    /**
     * @var string
     */
    private $serviceId;
    /**
     * @var string
     */
    private $produto;

    public function __construct(string $msisdn, string $cpf, string $email, string $purchaseOrderNumber, string $serviceId, string $produto)
    {
        $this->msisdn = $msisdn;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->purchaseOrderNumber = $purchaseOrderNumber;
        $this->serviceId = $serviceId;
        $this->produto = $produto;
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
        return 'http://' . env('GVT_BACKEND_URL', '172.18.0.4') . '/tests/solicitar_chave.php';
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getBody(): array
    {
        return [
            'msisdn' => $this->msisdn,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'purchaseOrderNumber' => $this->purchaseOrderNumber,
            'serviceId' => $this->serviceId,
            'produto' => $this->produto,
        ];
    }
}
