<?php


namespace App\Services\Application\Http\Payloads\Gvt;


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

    public function __construct(stdClass $params)
    {
        $this->msisdn = $params->msisdn;
        $this->cpf = $params->cpf;
        $this->email = $params->email;
        $this->purchaseOrderNumber = $params->purchaseOrderNumber;
        $this->serviceId = $params->serviceId;
        $this->produto = $params->produto;
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
        return 'http://' . env('GVT_BACKEND_URL') . '/tests/solicitar_chave.php';
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

    public function getBody(): string
    {
        $data = [
            'msisdn' => $this->msisdn,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'purchaseOrderNumber' => $this->purchaseOrderNumber,
            'serviceId' => $this->serviceId,
            'produto' => $this->produto,
        ];
        return http_build_query($data, null, '&');

    }
}
