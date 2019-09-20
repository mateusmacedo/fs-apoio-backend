<?php


namespace App\Services\Application\Http\Payloads\Factories;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Payloads\Tim\CancelarChave as CancelarChaveTim;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use RuntimeException;
use stdClass;

class CancelarChavePaylodFactory extends AbstractPayloadFactory
{

    public static function create(Collection $body): PayloadInterface
    {
        if (!$body->keys()->contains(env('KEY_OPERADORA_IN_FILE')) || !in_array($body->get(env('KEY_OPERADORA_IN_FILE')), self::VALID_OPERATORS)) {
            throw new InvalidArgumentException('Namespace da Operadora invalido');
        }
        switch (strtolower($body->get(env('KEY_OPERADORA_IN_FILE')))) {
            case 'gvt':
                throw new RuntimeException('Payload Gvt não implementado');
                break;
            case 'tim':
                $payloadData = static::buildTim($body);
                $payload = new CancelarChaveTim($payloadData);
                break;
            default:
                throw new RuntimeException('Payload não criado');
                break;
        }
        return $payload;
    }

    static private function buildTim(Collection $data): stdClass
    {
        $required = collect([
            'chave' => '',
        ]);
        $optional = collect([
            'motivo' => 'descontinuado',
            'vendedor' => '',
            'silent' => true,
            'client_correlator' => '',
            'bi_acao' => 'cancelamento',
            'canal_cancelamento' => '',
        ]);
        return static::hydrate($data, $required, $optional);
    }
}
