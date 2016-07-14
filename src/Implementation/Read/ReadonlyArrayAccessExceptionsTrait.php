<?php

namespace Nayjest\Collection\Implementation\Read;

use Nayjest\Collection\Common\Utils;
use Nayjest\Collection\Exception\ReadonlyException;

trait ReadonlyArrayAccessExceptionsTrait
{
    public function offsetSet($offset, $value)
    {
        $type = Utils::getValueInfoForException($value);
        throw new ReadonlyException("Trying to set value {{$type}} to offset: {{$offset}}");
    }

    public function offsetUnset($offset)
    {
        throw new ReadonlyException("Trying to unset offset: {$offset}");
    }
}