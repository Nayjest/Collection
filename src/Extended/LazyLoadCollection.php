<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionInterface;
use Nayjest\Collection\CollectionTrait;
use Nayjest\Collection\Collection;

/**
 * Collection with deferred initialization (lazy load).
 *
 * Initialization callback executes when accessing collection items first time.
 *
 */
class LazyLoadCollection implements CollectionInterface
{
    use CollectionTrait {
        CollectionTrait::items as private itemsInternal;
    }

    private $initialized = false;
    private $initializer;

    /**
     * Constructor.
     *
     * Callback passed to $initializer argument
     * will be executed when accessing collection items first time.
     *
     * @param callable $initializer callable that returns collection items
     */
    public function __construct(callable $initializer)
    {
        $this->initializer = $initializer;
    }

    protected function &items()
    {
        if (!$this->initialized) {
            $data = &$this->itemsInternal();
            $data = call_user_func($this->initializer);
            $this->initialized = true;
        }

        return $this->itemsInternal();
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
        return new Collection($items);
    }
}
