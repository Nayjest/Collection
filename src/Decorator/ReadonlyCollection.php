<?php

namespace Nayjest\Collection\Decorator;

use Nayjest\Collection\Collection;
use Nayjest\Collection\CollectionReadInterface;
use Nayjest\Collection\CollectionReadTrait;

class ReadonlyCollection implements CollectionReadInterface
{
    use CollectionReadTrait;

    private $collection;
    private $data;

    /**
     * @param CollectionReadInterface $collection
     */
    public function __construct(CollectionReadInterface $collection)
    {
        $this->collection = $collection;
    }

    protected function createCollection(array $items)
    {
        return new static(new Collection($items));
    }

    protected function &items()
    {
        $this->data = $this->collection->toArray();

        return $this->data;
    }
}
