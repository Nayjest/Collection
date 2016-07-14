<?php

namespace Nayjest\Collection\Behavior;

use Evenement\EventEmitter;
use Nayjest\Collection\CollectionWrapper;

abstract class AbstractBehavior implements BehaviorInterface
{
    const supportedEvents = [
        CollectionWrapper::BEFORE_ITEM_ADD => 'beforeItemAdd',
        CollectionWrapper::AFTER_ITEM_ADD => 'afterItemAdd',
        CollectionWrapper::AFTER_ITEM_REMOVE => 'afterItemRemove',
        CollectionWrapper::BEFORE_ITEM_REMOVE => 'beforeItemRemove',
    ];

    public static function make($options = null)
    {
        return new static($options);
    }

    public function applyTo(EventEmitter $e)
    {
        foreach($this::supportedEvents as $event => $method) {
            if (method_exists($this, $method)) {
                $e->on($event, [$this, $method]);
            }
        }
    }
}