<?php


namespace App\Services\Application\Http\Payloads\Factories;


use Illuminate\Support\Collection;
use InvalidArgumentException;
use stdClass;

abstract class AbstractPayloadFactory
{
    const VALID_OPERATORS = ['tim', 'gvt', 'vivo', 'oi', 'claro'];

    static protected function hydrate(Collection $data, Collection $required, Collection $optional): stdClass
    {
        $dataKeys = $data->keys();
        $required->keys()->each(static function ($Key) use ($dataKeys) {
            if (!$dataKeys->contains($Key)) {
                throw new InvalidArgumentException("chave {$Key} requerida para a criação do payloaD");
            }
        });
        $keys = $required->merge($optional);
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
}
