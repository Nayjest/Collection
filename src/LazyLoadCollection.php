<?php

namespace Nayjest\Collection;

/**
 * Class LazyLoadCollection.
 *
 * LazyLoadCollection is a collection that's initialized by callback
 * when it's accessed first time.
 *
 */
class LazyLoadCollection implements CollectionInterface
{
    use CollectionTrait {
        CollectionTrait::items as private itemsInternal;
    }

    private $initialized = false;
    private $initializer;

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
