<?php


namespace App\Services\Application\Http\Payloads\Gvt;


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
        $payloadParams = $this->objectToArray($this->params);
        return http_build_query($payloadParams, null, '&');

    }
}
