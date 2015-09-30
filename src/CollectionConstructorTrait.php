<?php

namespace Nayjest\Collection;

/**
 * Basic collection constructor implementation.
 */
trait CollectionConstructorTrait
{
    abstract public function set($items);

    /**
     * Constructor.
     *
     * @param array|null $items collection items
     */
    public function __construct(array $items = null)
    {
        if ($items !== null) {
            $this->set($items);
        }
    }
}
