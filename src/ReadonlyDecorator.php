<?php

namespace Nayjest\Collection;

class ReadonlyDecorator implements CollectionReadInterface
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
        }
    }

    protected function createCollection(array $items)
    {
        return new static($items);
    }
}
