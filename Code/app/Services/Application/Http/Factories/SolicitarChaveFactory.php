<?php


namespace App\Services\Application\Http\Factories;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Payloads\Gvt\SolicitarChave as SolicitarChaveGvt;
use App\Services\Application\Http\Payloads\Tim\SolicitarChave as SolicitarChaveTim;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use RuntimeException;
use stdClass;

class SolicitarChaveFactory
{
    const VALID_OPERATORS = ['tim', 'gvt', 'vivo', 'oi', 'claro'];

    static private function hydrate(Collection $data, Collection $required, Collection $optional)
    {
        $dataKeys = collect($data)->keys();
        $required->keys()->each(static function ($Key) use ($dataKeys) {
            if (!$dataKeys->contains($Key)) {
                throw new RuntimeException("chave {$Key} requerida para a criação do payloa");
            }
        });
        $keys = $required->merge($optional);
        $data = collect($data);
        $result = new stdClass();
        $keys->each(static function ($item, $key) use (&$result, $data) {
            $camelKey = camel_case($key);
            if (!$data->contains($key, $item)) {
                $result->$camelKey = $item;
            } else {
                $result->$camelKey = $data->get($key);
            }
        });
        return $result;
    }

    static private function buildChaveGvt(Collection $data)
    {
        $required = collect([
        ]);
        $optional = collect([
        ]);
        return static::hydrate($data, $required, $optional);
    }

    static private function buildChaveTim(Collection $data): stdClass
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
        if (!$body->keys()->contains('operadora') || !in_array($body->get('operadora'), self::VALID_OPERATORS)) {
            throw new InvalidArgumentException('Namespace da Operadora invalido');
        }
        switch (strtolower($body->get('operadora'))) {
            case 'gvt':
                $payloadData = static::buildChaveGvt($body);
                $payload = new SolicitarChaveGvt($payloadData);
                break;
            case 'tim':
                $payloadData = static::buildChaveTim($body);
                $payload = new SolicitarChaveTim($payloadData);
                break;
            default:
                throw new RuntimeException('Payload não criado');
                break;
        }
        return $payload;
    }
}
