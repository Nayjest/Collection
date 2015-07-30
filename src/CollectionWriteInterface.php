<?php

namespace Nayjest\Collection;

use Traversable;

/**
 * Interface CollectionWriteInterface.
 *
 * The interface describes methods that changes collection.
 */
interface CollectionWriteInterface
{
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
     * Adds items to collection.
     *
     * @param array|Traversable $items
     * @param bool              $prepend false by default
     *
     * @return $this
     */
    public function addMany($items, $prepend = false);

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
     * Sets collection items.
     *
     * @param array|Traversable $items
     *
     * @return $this
     */
    public function set($items);
}
