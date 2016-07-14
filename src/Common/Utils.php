<?php

namespace Nayjest\Collection\Common;

use Nayjest\Collection\Exception\NotArrayOrTraversableException;
use Traversable;

class Utils
{
    public static function toArray($data)
    {
        if (is_array($data)) {
            return $data;
        }
        if ($data instanceof Traversable) {
            return iterator_to_array($data);
        }
        throw new NotArrayOrTraversableException;
    }

    public static function bindArguments(callable $callback, array $arguments = null)
    {
        if ($arguments === null) {
            return $callback;
        }
        if (isset($arguments[0])) {
            return function ($firstArgument) use ($callback, $arguments) {
                return call_user_func_array(
                    $callback,
                    array_merge([$firstArgument], $arguments)
                );
            };
        } else {
            return function () use ($callback, $arguments) {
                return call_user_func_array(
                    $callback,
                    $arguments + func_get_args()
                );
            };
        }
    }

    public static function getValueInfoForException($value)
    {
        if (is_object($value)) {
            return get_class($value);
        }
        if (is_numeric($value)) {
            return (string)$value;
        }
        return gettype($value);
    }
}
