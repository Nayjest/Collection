<?php

namespace Nayjest\Collection;

trait CollectionConstructorTrait
{
    abstract public function set($items);

    public function __construct(array $items = null)
    {
        if ($items !== null) {
            $this->set($items);
        }
    }
}
