<?php

namespace Nayjest\Collection\Implementation\Read;

trait ReadMethodAliasesTrait
{
    abstract public function has($item);
    abstract public function indexOf($item);
    abstract public function get($key, $default = null);
    abstract public function hasKey($key);

    public function contains($item)
    {
        return $this->has($item);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset, null);
    }
    public function getKey($item)
    {
        return $this->indexOf($item);
    }

    public function offsetExists($offset)
    {
        return $this->hasKey($offset);
    }

}