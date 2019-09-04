<?php


namespace App\Services\Application\Factories;


use App\Services\Application\Payloads\Gvt\SolicitarChave;
use InvalidArgumentException;
use RuntimeException;

class SolicitarChaveFactory
{
    const VALID_PERATORS = ['tim', 'gvt', 'vivo', 'oi', 'claro'];

    public static function create(array $data)
    {
        if (!array_key_exists('operadora', $data) || !in_array(strtolower($data['operadora']), static::VALID_PERATORS)) {
            throw new InvalidArgumentException('Namespace da Operadora invalido');
        }
        switch (strtolower($data['operadora'])) {
            case 'gvt':
                $payload = $data['payload'];
                $payload = new SolicitarChave($payload['msisdn'], $payload['cpf'], $payload['email'], $payload['purchaseOrderNumber'], $payload['serviceId'], $payload['produto']);
                break;
            case 'tim':
                throw new RuntimeException('Não implementado');
                break;
            default:
                throw new RuntimeException('Payload não criado');
                break;
        }
        return $payload;
    }
}
