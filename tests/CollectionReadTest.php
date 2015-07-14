<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;

class CollectionReadTest extends AbstractCollectionReadTest
{
    protected function makeCollection($data)
    {
        return new Collection($data);
    }
}
