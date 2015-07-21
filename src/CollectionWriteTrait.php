<?php

namespace Nayjest\Collection;

use Traversable;

/**
 * Trait CollectionWriteTrait
 * @implements \Nayjest\Collection\CollectionWriteInterface
 */
trait CollectionWriteTrait
{

    /**
     * Returns reference to array storing collection items.
     *
     * @return array
     */
    abstract protected function &items();

    /**
     * Adds item to collection.
     *
     * @param $item
     * @param bool $prepend false by default
     * @return $this
     */
    public function addItem($item, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->items(), $item);
        } else {
            $this->items()[] = $item;
        }
        return $this;
    }

    /**
     * Removes items equals to specified value from collection.
     *
     * @param $item
     * @return $this
     */
    public function remove($item)
    {
        while (($key = array_search($item, $this->items(), true)) !== false) {

            unset($this->items()[$key]);
        }
        return $this;
    }

    /**
     * Removes all items from collection.
     *
     * @return $this
     */
    public function clear()
    {
        $items =& $this->items();
        // It's not mistake that $items never used after assigning empty array.
        // Yep, it really clears the collection.
        $items = [];
        return $this;
    }

    /**
     * Adds items to collection.
     *
     * @param array|Traversable $items
     * @param bool $prepend false by default
     * @return $this
     */
    public function addItems($items, $prepend = false)
    {
        if ($prepend) {
            # if items must be added to beginning, we need to reverse them
            if (!is_array($items)) {
                $items = iterator_to_array($items);
            }
            $items = array_reverse($items);
        }
        foreach ($items as $item) {
            $this->addItem($item, $prepend);
        }
        return $this;
    }

    /**
     * Sets collection items.
     *
     * @param array|Traversable $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->clear();
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * Creates collection of items.
     *
     * Override it if you need to implement
     * derived collection that requires specific initialization.
     *
     * @param array $items
     * @return static
     */
    protected function createCollection(array $items)
    {
        $collection = new static;
        $collection->setItems($items);
        return $collection;
    }
}
