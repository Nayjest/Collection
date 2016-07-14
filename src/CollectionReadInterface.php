<?php

namespace Nayjest\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * CollectionReadInterface describes methods for reading from collection.
 */
interface CollectionReadInterface extends IteratorAggregate, Countable, ArrayAccess
{
    /**
     * Returns collection items in array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Returns true if collection is empty.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns first item of the collection or null if collection is empty.
     *
     * @return mixed|null
     */
    public function first();

    public function last();

    /**
     * Checks that collections contains target item.
     *
     * @param $item
     *
     * @return bool
     */
    public function contains($item);
    public function has($item);

    public function indexOf($item);

    public function hasKey($offset);
    public function offsetExists($offset);

    public function get($key, $default = null);
    public function offsetGet($offset);

    public function getKeys();

    public function getValues();

    /**
     * Iterates over each value in the <b>collection</b>
     * passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the
     * current value from <b>collection</b> is returned into
     * the result collection.
     *
     * @param callable   $callback          the callback function to use
     *
     * @return CollectionReadInterface|static filtered collection
     */
    public function filter(callable $callback);

    /**
     * Iterates over each value in the <b>collection</b>
     * passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the
     * current value from <b>collection</b> is returned.
     *
     * @param callable   $callback          the callback function to use
     *
     * @return mixed|FALSE collection item or false if item is not found.
     */
    public function find(callable $callback);

    /**
     * @param callable   $callback          the callback function to use
     * @return CollectionReadInterface|static
     */
    public function map(callable $callback);

    /**
     * @param callable $compareFunction
     * @return CollectionReadInterface|static
     */
    public function sort(callable $compareFunction);

    public function slice($offset, $length = null);

    /**
     * Returns random collection element or NULL for empty collection.
     * @return mixed|null
     */
    public function random();

//    /**
//     * @param $item
//     * @return CollectionReadInterface|static
//     */
//    public function beforeItem($item);
//
//    /**
//     * @param $item
//     * @return CollectionReadInterface|static
//     */
//    public function afterItem($item);
//
//    /**
//     * Returns true if collection implements CollectionWriteInterface.
//     *
//     * @return bool
//     */
//    public function isWritable();

    /**
     * @param string $className
     * @return static
     */
    public function filterByType($className);

    /**
     * @param string $propertyName
     * @param $value
     * @return static
     */
    public function filterByProperty($propertyName, $value);

    /**
     * @param string $propertyName
     * @param $value
     * @return mixed
     */
    public function findByProperty($propertyName, $value);
}
