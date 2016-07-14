<?php

namespace Nayjest\Collection\Common;
use IteratorIterator;
use Traversable;

/**
 * Maps values before yielding
 */
class MapIterator extends IteratorIterator
{

    protected $callback;

    public function __construct(Traversable $iterator, callable $callback)
    {
        parent::__construct($iterator);
        $this->callback = $callback;
    }
    public function current()
    {
        return call_user_func($this->callback, parent::current());
    }
}