<?php
namespace Nayjest\Collection;

use Countable;
use IteratorAggregate;

interface CollectionReadInterface extends IteratorAggregate, Countable
{
    public function toArray();

    public function isEmpty();

    public function has($item);

    public function first();

    public function contains($item);

    public function filter(callable $callback);
}
