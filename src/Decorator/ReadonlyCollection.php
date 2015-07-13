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

    protected function &items()
    {
        $this->data = $this->collection->toArray();
        return $this->data;
    }

    /**
     * @param CollectionReadInterface|array $collection
     */
    public function __construct(CollectionReadInterface $collection)
    {
        $this->collection = $collection;
    }

    protected function createCollection(array $items)
    {
        $collection = new Collection();
        $collection->setItems($items);
        return new static($collection);
    }
}
