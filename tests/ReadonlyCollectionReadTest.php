<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;
use Nayjest\Collection\Decorator\ReadonlyCollection;

class ReadonlyCollectionReadTest extends AbstractCollectionReadTest
{
    protected function makeCollection($data)
    {
        return new ReadonlyCollection(new Collection($data));
    }
}
