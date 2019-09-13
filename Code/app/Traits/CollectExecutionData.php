<?php


namespace App\Traits;


use ArrayIterator;

trait CollectExecutionData
{
    public function getMethodData(string $method, array $args)
    {
        $result = [];
        foreach ($args as $key => $value) {
            if (is_object($value)) {
                $result[$key] = get_class($value);
                if ($value instanceof ArrayIterator) {
                    $result[$key]['data'] = $value->getArrayCopy();
                }
            } elseif (is_resource($value)) {
                $result[$key] = get_resource_type($value);
            } elseif (is_array($value) || is_scalar($value)) {
                $result[$key] = $value;
            } else {
                $result[$key] = 'undefined';
            }
        }

        return [
            'method' => $method,
            'params' => [
                $result
            ]
        ];
    }
}
