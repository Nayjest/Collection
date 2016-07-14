<?php

namespace Nayjest\Collection;

/**
 * CollectionWriteInterface describes methods that changes collection.
 */
interface CollectionInterface extends CollectionReadInterface
{
    /**
     * @param $item
     * @return $this
     */
    public function prepend($item);

    /**
     * @param $items
     * @return $this
     */
    public function prependMany($items);

    /**
     * @param $item
     * @return $this
     */
    public function append($item);

    /**
     * This method is alias of 'append'.
     *
     * @param $item
     * @return $this
     */
    public function add($item);

    /**
     * Adds elements to the end of collection. Does not preserves keys.
     *
     * @param array $items
     * @return $this
     */
    public function appendMany($items);

    /**
     * @param $items
     * @return $this
     */
    public function addMany($items);

    /**
     * @param $items
     * @return $this
     */
    public function merge($items);

    /**
     * @param $oldItem
     * @param $newItem
     * @return $this
     */
    public function replace($oldItem, $newItem);

    /**
     * @param $oldItem
     * @param $newItem
     * @return $this
     */
    public function replaceOrAdd($oldItem, $newItem);

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
     * @param $item
     * @return $this
     */
    public function removeFirst($item);

    /**
     * @param $key
     * @return $this
     */
    public function removeByKey($key);

    /**
     * @param $item
     * @return $this
     */
    public function moveUp($item);

    /**
     * @param $item
     * @return $this
     */
    public function moveDown($item);
}
