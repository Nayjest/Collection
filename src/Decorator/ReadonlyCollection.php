<?php

namespace Nayjest\Collection\Decorator;

use InvalidArgumentException;
use Nayjest\Collection\CollectionDataTrait;
use Nayjest\Collection\CollectionReadInterface;
use Nayjest\Collection\CollectionReadTrait;

class ReadonlyCollection implements CollectionReadInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;

    /**
     * @param CollectionReadInterface|array $collection
     */
    public function __construct($collection)
    {
        if ($collection instanceof CollectionReadInterface)
        {
            $this->data = $collection->toArray();
        } elseif(is_array($collection)) {
            $this->data = $collection;
        } else {
            throw new InvalidArgumentException;
        }
    }

    protected function createCollection(array $items)
    {
        return new static($items);
    }
}
