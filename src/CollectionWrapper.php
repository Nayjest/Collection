<?php

namespace Nayjest\Collection;

use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;
use Nayjest\Collection\Behavior\BehaviorInterface;
use Nayjest\Collection\Common\Utils;
use Nayjest\Collection\Implementation\MethodAliasesTrait;
use Nayjest\Collection\Implementation\Read\ObjectCollectionReadTrait;
use Nayjest\Collection\Implementation\Read\ReadWrapperTrait;

class CollectionWrapper implements CollectionInterface
{
    use ReadWrapperTrait;
    use ObjectCollectionReadTrait;
    use MethodAliasesTrait;

    const BEFORE_ITEM_ADD = 'before_item_add';
    const AFTER_ITEM_ADD = 'after_item_add';
    const BEFORE_ITEM_REMOVE = 'before_item_remove';
    const AFTER_ITEM_REMOVE = 'after_item_remove';

    /** @var EventEmitterInterface */
    protected $eventEmitter;

    /**
     * @var CollectionInterface
     */
    protected $data;

    /**
     * CollectionWrapper constructor.
     *
     * @param CollectionInterface $collection
     * @param EventEmitterInterface|callable[]|BehaviorInterface[]|null $events
     */
    public function __construct(CollectionInterface $collection, $events = null)
    {
        $this->data = $collection;
        $this->initializeEvents($events);
    }

    public function on($event, callable $listener)
    {
        $this->eventEmitter->on($event, $listener);
        return $this;
    }

    public function append($item)
    {
        $this->eventEmitter->emit(self::BEFORE_ITEM_ADD, [&$item, $this, null]);
        $this->data->{__FUNCTION__}($item);
        $this->eventEmitter->emit(self::AFTER_ITEM_ADD, [$item, $this, null]);
        return $this;
    }

    public function prepend($item)
    {
        $this->eventEmitter->emit(self::BEFORE_ITEM_ADD, [&$item, $this, null]);
        $this->data->{__FUNCTION__}($item);
        $this->eventEmitter->emit(self::AFTER_ITEM_ADD, [$item, $this, null]);
        return $this;
    }

    public function appendMany($items)
    {
        foreach ($items as $item) {
            $this->append($item);
        }
        return $this;
    }

    public function prependMany($items)
    {
        $items = array_reverse(Utils::toArray($items));
        foreach ($items as $item) {
            $this->prepend($item);
        }
        return $this;
    }

    public function merge($items)
    {
        $items = Utils::toArray($items);
        foreach($items as $key => $value) {
            if (is_string($key)) {
                $this->offsetSet($key, $value);
            } else {
                $this->add($value);
            }
        }
        return $this;
    }

    public function clear()
    {
        foreach($this->data as $item) {
            $this->data->remove($item);
        }
        return $this;
    }

    public function remove($item)
    {
        foreach($this->data as $key => $value) {
            if ($value === $item) {
                $this->eventEmitter->emit(self::BEFORE_ITEM_REMOVE, [&$item, $this]);
                unset($this->data[$key]);
                $this->eventEmitter->emit(self::AFTER_ITEM_REMOVE, [$item, $this]);
            }
        }
        return $this;
    }

    public function removeFirst($item)
    {
        $this->eventEmitter->emit(self::BEFORE_ITEM_REMOVE, [&$item, $this]);
        $this->data->{__FUNCTION__}($item);
        $this->eventEmitter->emit(self::AFTER_ITEM_REMOVE, [$item, $this]);
        return $this;
    }

    public function offsetUnset($key)
    {
        $this->remove($this->get($key));
        return $this;
    }

    public function replace($oldItem, $newItem)
    {
        if ($oldItem === $newItem) {
            return $this;
        }
        $index = $this->indexOf($oldItem);
        if ($index === false) {
            throw new \Exception('Nothing to replace');
        }
        $this->offsetSet($index, $newItem);
        return $this;
    }

    public function replaceOrAdd($oldItem, $newItem)
    {
        try {
            $this->replace($oldItem, $newItem);
        } catch (\Exception $e) {
            $this->add($newItem);
        }
        return $this;
    }

    public function offsetSet($offset, $value)
    {
        $this->eventEmitter->emit(self::BEFORE_ITEM_ADD, [&$value, $this, &$offset]);
        // remove old item for calling item remove events
        if ($this->hasKey($offset)) {
            $this->removeByKey($offset);
        }
        $this->data->{__FUNCTION__}($offset, $value);
        $this->eventEmitter->emit(self::AFTER_ITEM_ADD, [$value, $this, $offset]);
        return $this;
    }

    public function moveUp($item)
    {
        $key = $this->indexOf($item);
        if (false === $key) {
            throw new \Exception('Nothing to move up');
        }
        if ($item === $this->first()) {
            return $this;
        }
        $keys = $this->getKeys();
        $prevKey = $keys[array_search($key, $keys, true) - 1];
        $this->data[$key] = $this->data[$prevKey];
        $this->data[$prevKey] = $item;
        return $this;
    }

    public function moveDown($item)
    {
        $key = $this->indexOf($item);
        if (false === $key) {
            throw new \Exception('Nothing to move up');
        }
        if ($item === $this->last()) {
            return $this;
        }
        $keys = $this->getKeys();
        $nextKey = $keys[array_search($key, $keys, true) + 1];
        $this->data[$key] = $this->data[$nextKey];
        $this->data[$nextKey] = $item;
        return $this;
    }

//    protected function createCollection($data)
//    {
//        if (is_array($data)) {
//            $data = new Collection($data);
//        }
//        $collection = new static($data);
//        return $collection;
//    }


    /**
     * @param EventEmitterInterface|BehaviorInterface[]|callable[]|null $events
     * @throws \Exception
     */
    protected function initializeEvents($events)
    {
        if ($events instanceof EventEmitterInterface) {
            $this->eventEmitter = $events;
        } else {
            $this->eventEmitter = new EventEmitter();
            if ($events !== null) {
                foreach ($events as $event => $listener) {
                    if ($listener instanceof BehaviorInterface) {
                        $listener->applyTo($this->eventEmitter);
                    } elseif(is_callable($listener)) {
                        $this->eventEmitter->on($event, $listener);
                    } else {
                        throw new \Exception("Wrong event listener");
                    }
                }
            }
        }
    }
}