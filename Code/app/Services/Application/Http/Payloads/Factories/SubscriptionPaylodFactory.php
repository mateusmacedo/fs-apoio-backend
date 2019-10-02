<?php


namespace App\Services\Application\Http\Payloads\Factories;


use App\Services\Application\Http\Interfaces\PayloadInterface;
use App\Services\Application\Http\Payloads\Claro\Subscription;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use RuntimeException;
use stdClass;

class SubscriptionPaylodFactory extends AbstractPayloadFactory
{
    public static function create(Collection $body): PayloadInterface
    {
        if (!$body->keys()->contains(env('KEY_OPERADORA_IN_FILE')) || !in_array(strtolower($body->get(env('KEY_OPERADORA_IN_FILE'))), self::VALID_OPERATORS)) {
            throw new InvalidArgumentException('Namespace da Operadora invalido');
        }
        if (strtolower($body->get(env('KEY_OPERADORA_IN_FILE'))) == 'claro') {
            $payloadData = static::buildClaro($body);
            $payload = new Subscription($payloadData);
        } else {
            throw new RuntimeException('Payload não criado');

        }
        return $payload;
    }

    static private function buildClaro(Collection $data): stdClass
    {
        $required = collect([
            'subscription_id' => '',
            'identifier' => '',
            'fs_product_id' => '',
            'la' => '',
        ]);
        $optional = collect([
            'silent' => true,
            'partner' => 'claro',
            'canceler' => 'SMS',
            'action' => 'A',
            'reason' => 'BUNDLE',
        ]);
        return static::hydrate($data, $required, $optional);
    }
}
