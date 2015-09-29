<?php

namespace Nayjest\Collection;

use ArrayIterator;
use IteratorIterator;

/**
 * Trait CollectionReadTrait.
 *
 * @implements \Nayjest\Collection\CollectionWriteInterface
 */
trait CollectionReadTrait
{
    /**
     * Returns reference to array storing collection items.
     *
     * @return array
     */
    abstract protected function &items();

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
        $itemsRef = &$collection->items();
        $itemsRef = $items;

        return $collection;
    }

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
     *
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

    /**
     * Returns first item of the collection or null if collection is empty.
     *
     * @return mixed|null
     */
    public function first()
    {
        return $this->isEmpty() ? null : array_values($this->items())[0];
    }

    /**
     * Iterates over each value in the <b>collection</b>
     * passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the
     * current value from <b>collection</b> is returned into
     * the result collection.
     *
     * @param callable   $callback          the callback function to use
     * @param array|null $optionalArguments [optional] additional arguments passed to callback
     *
     * @return CollectionReadInterface|static filtered collection
     */
    public function filter(callable $callback, array $optionalArguments = null)
    {
        return $this->createCollection(array_filter(
            $this->items(),
            self::bindAdditionalArguments($callback, $optionalArguments)
        ));
    }

    /**
     * Iterates over each value in the <b>collection</b>
     * passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the
     * current value from <b>collection</b> is returned.
     *
     * @param callable   $callback          the callback function to use
     * @param array|null $optionalArguments [optional] additional arguments passed to callback
     *
     * @return mixed|FALSE collection item or false if item is not found.
     */
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

        return false;
    }


    /**
     * @param callable   $callback          the callback function to use
     * @param array|null $optionalArguments [optional] additional arguments passed to callback
     * @return CollectionReadInterface|static
     */
    public function map(callable $callback, array $optionalArguments = null)
    {
        return $this->createCollection(array_map(
            self::bindAdditionalArguments($callback, $optionalArguments),
            $this->items()
        ));
    }

    /**
     * @param callable $compareFunction
     * @return CollectionReadInterface|static
     */
    public function sort(callable $compareFunction)
    {
        $items = $this->toArray();
        usort($items, $compareFunction);
        return $this->createCollection($items);
    }

    /**
     * @return mixed|null
     */
    public function random()
    {
        $index = array_rand($this->items());
        return $index === null ? null : $this->items()[$index];
    }

    public function isWritable()
    {
        return $this instanceof CollectionWriteInterface;
    }

    protected static function bindAdditionalArguments(callable $callback, array $additionalArguments = null)
    {
        if ($additionalArguments === null) {
            return $callback;
        }
        return function ($item) use ($callback, $additionalArguments) {
            $arguments = array_merge([$item], $additionalArguments);
            return call_user_func_array($callback, $arguments);
        };
    }
}
