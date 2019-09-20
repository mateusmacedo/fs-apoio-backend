<?php


namespace App\Services\Application\Http\Payloads\Factories;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Payloads\Gvt\SolicitarChave as SolicitarChaveGvt;
use App\Services\Application\Http\Payloads\Tim\SolicitarChave as SolicitarChaveTim;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use RuntimeException;
use stdClass;

class SolicitarChavePaylodFactory extends AbstractPayloadFactory
{
    static private function buildGvt(Collection $data)
    {
        $required = collect([
        ]);
        $optional = collect([
        ]);
        return static::hydrate($data, $required, $optional);
    }

    static private function buildTim(Collection $data): stdClass
    {
        $required = collect([
            'subscription_id' => '',
            'pp_id' => '',
            'msisdn' => ''
        ]);
        $optional = collect([
            'canal' => '5512 - TIM',
            'email' => '',
            'nome' => '',
            'silent' => true,
            'transaction_options' => '',
            'bi_acao' => '',
            'vendedor' => '',
            'campanha' => ''
        ]);
        return static::hydrate($data, $required, $optional);
    }

    public static function create(Collection $body): PayloadInterface
    {
        if (!$body->keys()->contains(env('KEY_OPERADORA_IN_FILE')) || !in_array($body->get(env('KEY_OPERADORA_IN_FILE')), self::VALID_OPERATORS)) {
            throw new InvalidArgumentException('Namespace da Operadora invalido');
        }
        switch (strtolower($body->get(env('KEY_OPERADORA_IN_FILE')))) {
            case 'gvt':
                $payloadData = static::buildGvt($body);
                $payload = new SolicitarChaveGvt($payloadData);
                break;
            case 'tim':
                $payloadData = static::buildTim($body);
                $payload = new SolicitarChaveTim($payloadData);
                break;
            default:
                throw new RuntimeException('Payload não criado');
                break;
        }
        return $payload;
    }
}
