<?php

namespace Nayjest\Collection;

use Traversable;
use Evenement\EventEmitterInterface;

/**
 * CollectionWriteInterface describes methods that changes collection.
 */
interface CollectionWriteInterface extends EventEmitterInterface
{
    public function onItemAdd(callable $callback);

    public function onItemRemove(callable $callback);

    public function onChange(callable $callback);

    /**
     * Adds item to collection.
     *
     * @param $item
     * @param bool $prepend false by default
     *
     * @return $this
     */
    public function add($item, $prepend = false);

    /**
     * Adds multiple to collection.
     *
     * @param array|Traversable $items
     * @param bool $prepend false by default
     *
     * @return $this
     */
    public function addMany($items, $prepend = false);

    public function replace($oldItem, $newItem, $forceAdd = true);

    /**
     * Removes all items from collection.
     *
     * @return $this
     */
    public function clear();

    /**
     * Removes items equals to specified value from collection.
     *
     * @param $item
     *
     * @return $this
     */
    public function remove($item);

    /**
     * Removes old and sets new collection items.
     *
     * @param array|Traversable $items
     *
     * @return $this
     */
    public function set($items);
}
