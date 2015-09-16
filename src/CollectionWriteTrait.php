<?php

namespace Nayjest\Collection;

use Traversable;

/**
 * Trait CollectionWriteTrait.
 *
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

    private $onItemAddCallbacks;

    public function onItemAdd(callable $callback)
    {
        if (null === $this->onItemAddCallbacks) {
            $this->onItemAddCallbacks = [$callback];
        } else {
            $this->onItemAddCallbacks[] = $callback;
        }
    }

    /**
     * Adds item to collection.
     *
     * @param $item
     * @param bool $prepend false by default
     * @param bool $ignoreCallbacks
     * @return $this
     */
    public function add($item, $prepend = false, $ignoreCallbacks = false)
    {
        if ($this->onItemAddCallbacks !== null && !$ignoreCallbacks) {
            foreach($this->onItemAddCallbacks as $callback) {
                $result = call_user_func($callback, $item, $this);
                if ($result === false) {
                    return $this;
                }
            }
        }
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
     *
     * @return $this
     */
    public function remove($item)
    {
        $keys = array_keys($this->items(), $item, true);
        foreach($keys as $key) {
            unset($this->items()[$key]);
        }
        return $this;
    }

    /**
     * Replaces items equal to $oldItem to $newItem
     *
     * @param $oldItem
     * @param $newItem
     * @param bool $forceAdd [optional] true by default; will add $newItem to collection if there is no items equal to $oldItem
     * @return $this
     */
    public function replace($oldItem, $newItem, $forceAdd = true)
    {
        $keys = array_keys($this->items(), $oldItem, true);
        if (count($keys) === 0) {
            if ($forceAdd) {
                $this->add($newItem);
            }
        } else {
            $this->remove($oldItem);
            foreach($keys as $key) {
                $this->add($newItem);
                // move to old item position
                $newKeys = array_keys($this->items(), $newItem, true);
                $lastAddedKey = array_pop($newKeys);
                $this->items()[$key] = $this->items()[$lastAddedKey];
                unset($this->items()[$lastAddedKey]);
            }
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
        $items = &$this->items();
        // It's not mistake that $items never used after assigning empty array.
        // Yep, it really clears the collection.
        $items = [];

        return $this;
    }

    /**
     * Adds items to collection.
     *
     * @param array|Traversable $items
     * @param bool              $prepend false by default
     *
     * @return $this
     */
    public function addMany($items, $prepend = false)
    {
        if ($prepend) {
            # if items must be added to beginning, we need to reverse them
            if (!is_array($items)) {
                $items = iterator_to_array($items);
            }
            $items = array_reverse($items);
        }
        foreach ($items as $item) {
            $this->add($item, $prepend);
        }

        return $this;
    }

    /**
     * Sets collection items.
     *
     * @param array|Traversable $items
     *
     * @return $this
     */
    public function set($items)
    {
        $this->clear();
        foreach ($items as $item) {
            $this->add($item);
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
     *
     * @return static
     */
    protected function createCollection(array $items)
    {
        $collection = new static();
        $collection->set($items);

        return $collection;
    }
}
