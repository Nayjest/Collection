<?php

namespace Nayjest\Collection\Decorator;

use Nayjest\Collection\Collection;
use Nayjest\Collection\CollectionReadInterface;
use Nayjest\Collection\CollectionReadTrait;

/**
 * Implementation of composite design pattern for collections.
 *
 * @package Nayjest\Collection\Decorator
 */
class CompositeCollection implements CollectionReadInterface
{
    use CollectionReadTrait;

    /** @var CollectionReadInterface[]  */
    private $collections = [];
    private $data;

    /**
     * @return CollectionReadInterface[]
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @param CollectionReadInterface[] $collections
     *
     * @return $this
     */
    public function setCollections(array $collections)
    {
        $this->collections = $collections;

        return $this;
    }

    /**
     * Returns composed collection by index
     *
     * @param $index
     *
     * @return CollectionReadInterface
     */
    public function getCollection($index)
    {
        return array_key_exists($index, $this->collections)
            ? $this->collections[$index]
            : null;
    }

    protected function createCollection(array $items)
    {
        $collection = new static();
        $collection->setCollections([new Collection($items)]);

        return $collection;
    }

    /**
     * Returns reference to array storing collection items.
     *
     * @return array
     */
    protected function &items()
    {
        $this->updateData();

        return $this->data;
    }

    private function updateData()
    {
        $this->data = (count($this->collections) !== 0)
            ? call_user_func_array(
                'array_merge',
                array_map('iterator_to_array', $this->collections)
            ) : [];
    }
}
