<?php


namespace App\Traits;


use stdClass;

trait DataTransformer
{
    /**
     * @param stdClass $object
     * @return array|stdClass
     */
    function objectToArray(stdClass $object)
    {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        if (is_array($object)) {
            return array_map(__FUNCTION__, $object);
        } else {
            return $object;
        }
    }

    /**
     * @param array $array
     * @return array|object
     */
    function arrayToObject(array $array)
    {
        if (is_array($array)) {
            return (object)array_map(__FUNCTION__, $array);
        } else {
            return $array;
        }
    }
}
