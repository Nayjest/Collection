<?php
namespace Nayjest\Collection;

use ArrayIterator;
use IteratorAggregate;
use IteratorIterator;
use Traversable;

class Collection implements IteratorAggregate
{
    protected $items = [];

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
            array_unshift($this->items, $item);
        } else {
            $this->items[] = $item;
        }
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
        foreach($items as $item)
        {
            $this->addItem($item, $prepend);
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

        while (($key = array_search($item, $this->items, true)) !== false)
        {
            unset($this->items[$key]);
        }
        return $this;
    }

    /**
     * Returns collection items in array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Returns true if collection is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->items) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Checks that collections contains target item.
     *
     * @param $item
     * @return bool
     */
    public function contains($item)
    {
        return in_array($item, $this->items, true);
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
     * Removes all items from collection.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        // IteratorIterator used to deny unseting and modifying values and keys while iterating
        return new IteratorIterator(new ArrayIterator($this->items));
    }

    public function first()
    {
        return $this->isEmpty() ? null : array_values($this->items)[0];
    }

    /**
     * @draft
     *
     * @param string $className
     * @return array
     */
    public function ofType($className)
    {
        $res = [];
        foreach($this->items as $item) {
            if ($item instanceof $className) {
                $res[] = $item;
            }
        }
        return $res;
    }

    /**
     * @draft
     *
     * @param $className
     * @return null
     */
    public function firstOfType($className)
    {
        foreach($this->items as $item) {
            if ($item instanceof $className) {
                return $item;
            }
        }
        return null;
    }

    public function filter(callable $callback)
    {
        $filtered = array_filter($this->items, $callback);
        return $this->createCollection($filtered);
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
