<?php

namespace Nayjest\Collection;

use ArrayIterator;
use IteratorIterator;

trait CollectionReadTrait
{

    /**
     * @return &array
     */
    abstract protected function &items();

    /**
     * Creates collection of items.
     *
     * Override it if you need to implement
     * derived collection that requires specific initialization.
     *
     * @param array $items
     * @return static
     */
    abstract protected function createCollection(array $items);

    /**
     * Returns collection items in array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items();
    }

    /**
     * Returns true if collection is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->items()) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items());
    }

    /**
     * Checks that collections contains target item.
     *
     * @param $item
     * @return bool
     */
    public function contains($item)
    {
        return in_array($item, $this->items(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        // Modifying or deleting values while iterating will not affect collection data.
        // ArrayIterator wrapped to IteratorIterator to deny modifying and deleting values while iterating.
        // That will help to avoid possible errors in client code.
        return new IteratorIterator(new ArrayIterator($this->items()));
    }

    public function first()
    {
        return $this->isEmpty() ? null : array_values($this->items())[0];
    }

    /**
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback)
    {
        $filtered = array_filter($this->items(), $callback);
        return $this->createCollection($filtered);
    }

    public function find(callable $callback, array $optionalArguments = null)
    {
        foreach ($this->items() as $item) {
            $arguments = ($optionalArguments === null)
                ? [$item]
                : array_merge([$item], $optionalArguments);
            if (call_user_func_array($callback, $arguments)) {
                return $item;
            }
        }
        return null;
    }
}
