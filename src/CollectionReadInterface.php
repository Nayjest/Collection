<?php
namespace Nayjest\Collection;

use Countable;
use IteratorAggregate;

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

    public function first();

    public function contains($item);

    public function filter(callable $callback);

    public function find(callable $callback, array $optionalArguments = null);
}
