<?php

namespace Nayjest\Collection\Implementation\Read;

use Nayjest\Collection\Common\Utils;

trait ReadUsingForeachTrait
{
    public function has($value)
    {
        foreach($this->data as $current) {
            if ($current === $value) {
                return true;
            }
        }
        return false;
    }

    public function first()
    {
        foreach($this->data as $value) {
            return $value;
        }
        return false;
    }

    public function last()
    {
        $item = false;
        foreach ($this->data as $item) {
        }
        return $item;
    }

    public function hasKey($key)
    {
        foreach ($this->data as $currentKey => $value) {
            if ($key === $currentKey) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($item)
    {
        foreach ($this->data as $key => $value) {
            if ($value === $item) {
                return $key;
            }
        }
        return false;
    }

    public function find(callable $callback, array $arguments = null)
    {
        $callback = Utils::bindArguments($callback, $arguments);
        foreach ($this->data as $item) {
            if (call_user_func($callback, $item)) {
                return $item;
            }
        }
        return false;
    }
}