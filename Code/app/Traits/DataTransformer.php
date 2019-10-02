<?php


namespace App\Traits;


use stdClass;

trait DataTransformer
{
    /**
     * @param stdClass $object
     * @return array|stdClass
     */
    public function objectToArray(stdClass $object)
    {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return $object;
    }

    /**
     * @param array $array
     * @return array|object
     */
    public function arrayToObject(array $array)
    {
        if (is_array($array)) {
            return (object)array_map(__FUNCTION__, $array);
        } else {
            return $array;
        }
    }
}
