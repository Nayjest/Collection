<?php

namespace Nayjest\Collection;

use Countable;
use IteratorAggregate;

/**
 * CollectionReadInterface describes methods of immutable collection.
 */
interface CollectionReadInterface extends IteratorAggregate, Countable
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

    /**
     * Checks that collections contains target item.
     *
     * @param $item
     *
     * @return bool
     */
    public function contains($item);

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
    public function filter(callable $callback, array $optionalArguments = null);

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
    public function find(callable $callback, array $optionalArguments = null);

    /**
     * @param callable   $callback          the callback function to use
     * @param array|null $optionalArguments [optional] additional arguments passed to callback
     * @return CollectionReadInterface|static
     */
    public function map(callable $callback, array $optionalArguments = null);

    /**
     * @param callable $compareFunction
     * @return CollectionReadInterface|static
     */
    public function sort(callable $compareFunction);

    /**
     * Returns random collection element or NULL for empty collection.
     * @return mixed|null
     */
    public function random();

    /**
     * @param $item
     * @return CollectionReadInterface|static
     */
    public function beforeItem($item);

    /**
     * @param $item
     * @return CollectionReadInterface|static
     */
    public function afterItem($item);

    /**
     * Returns true if collection implements CollectionWriteInterface.
     *
     * @return bool
     */
    public function isWritable();
}
