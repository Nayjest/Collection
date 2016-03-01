<?php

namespace Nayjest\Collection;

use Evenement\EventEmitterTrait;
use Traversable;

/**
 * Trait CollectionWriteTrait.
 *
 * @implements \Nayjest\Collection\CollectionWriteInterface
 */
trait CollectionWriteTrait
{
    use EventEmitterTrait;

    /**
     * used to avoid emitting multiple 'change' events in complex operations.
     * @var bool|string
     */
    protected $onChangeAlreadyEmittedBy = false;

    /**
     * Emits onChange if not emitted before.
     *
     * @param string|bool $method if false, does not require calling endEmitOnChange
     */
    protected function emitOnChange($method = false)
    {
        if (!$this->onChangeAlreadyEmittedBy) {
            $this->emit('change', [$this]);
            $this->onChangeAlreadyEmittedBy = $method;
        }
    }

    protected function endEmitOnChange($method)
    {
        if ($this->onChangeAlreadyEmittedBy === $method) {
            $this->onChangeAlreadyEmittedBy = false;
        }
    }

    /**
     * Returns reference to array storing collection items.
     *
     * @return array
     */
    abstract protected function &items();

    /**
     * Adds event listener.
     *
     * @param callable $callback callback that accepts added item and collection as argument
     * @return $this
     */
    public function onItemAdd(callable $callback)
    {
        $this->on('item.add', $callback);
        return $this;
    }

    /**
     * Adds event listener.
     *
     * @param callable $callback callback that accepts removed item and collection as argument
     * @return $this
     */
    public function onItemRemove(callable $callback)
    {
        $this->on('item.remove', $callback);
        return $this;
    }

    /**
     * Adds event listener.
     *
     * @param callable $callback callback that accepts collection instance as argument
     * @return $this
     */
    public function onChange(callable $callback)
    {
        $this->on('change', $callback);
        return $this;
    }

    /**
     * Adds item to collection.
     *
     * @param $item
     * @param bool $prepend false by default
     * @return $this
     */
    public function add($item, $prepend = false)
    {
        $this->emitOnChange();
        $this->emit('item.add', [$item, $this]);
        $items = &$this->items();
        if ($prepend) {
            array_unshift($items, $item);
        } else {
            $items[] = $item;
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
        $this->emitOnChange();
        $this->emit('item.remove', [$item, $this]);

        $keys = array_keys($this->items(), $item, true);
        foreach ($keys as $key) {
            unset($this->items()[$key]);
        }
        return $this;
    }

    /**
     * Replaces items equal to $oldItem to $newItem.
     *
     * If $forceAdd is true, $newItem will be added to collection even if there is no $oldItem.
     *
     * @param $oldItem
     * @param $newItem
     * @param bool $forceAdd [optional] true by default
     * @return $this
     */
    public function replace($oldItem, $newItem, $forceAdd = true)
    {
        $this->emitOnChange(__METHOD__);
        $keys = array_keys($this->items(), $oldItem, true);
        if (count($keys) === 0) {
            if ($forceAdd) {
                $this->add($newItem);
            }
        } else {
            $this->remove($oldItem);
            foreach ($keys as $key) {
                $this->add($newItem);
                // move to old item position
                $newKeys = array_keys($this->items(), $newItem, true);
                $lastAddedKey = array_pop($newKeys);
                $this->items()[$key] = $this->items()[$lastAddedKey];
                unset($this->items()[$lastAddedKey]);
            }
        }
        $this->endEmitOnChange(__METHOD__);
        return $this;
    }

    /**
     * Removes all items from collection.
     *
     * @return $this
     */
    public function clear()
    {
        $this->emitOnChange(__METHOD__);
        $items = &$this->items();
        if (count($this->listeners('item.remove'))) {
            foreach ($items as $item) {
                $this->emit('item.remove', [$item, $this]);
            }
        }

        // It's not mistake that $items never used after assigning empty array.
        // Yep, it really clears the collection.
        $items = [];
        $this->endEmitOnChange(__METHOD__);
        return $this;
    }

    /**
     * Adds multiple items to collection.
     *
     * @param array|Traversable $items
     * @param bool $prepend false by default
     *
     * @return $this
     */
    public function addMany($items, $prepend = false)
    {
        $this->emitOnChange(__METHOD__);
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
        $this->endEmitOnChange(__METHOD__);
        return $this;
    }

    /**
     * Removes old and sets new collection items.
     *
     * @param array|Traversable $items
     *
     * @return $this
     */
    public function set($items)
    {
        $this->emitOnChange(__METHOD__);
        $this->clear();
        foreach ($items as $item) {
            $this->add($item);
        }
        $this->endEmitOnChange(__METHOD__);
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
