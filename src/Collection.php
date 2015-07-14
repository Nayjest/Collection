<?php

namespace Nayjest\Collection;

/**
 * Class Collection
 *
 * Basic collection implementation.
 *
 */
class Collection implements CollectionInterface
{
    use CollectionTrait;

    public function __construct(array $items = null)
    {
        $this->setItems($items ?: []);
    }
}
