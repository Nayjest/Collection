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
    use CollectionDataTrait;
    use CollectionReadTrait;
    use CollectionWriteTrait {
        CollectionWriteTrait::createCollection
        insteadof CollectionReadTrait;
    }

    public function __construct(array $items = null)
    {
        $this->setItems($items ?: []);
    }
}
