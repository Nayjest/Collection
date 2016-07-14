<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;

class CollectionReadTest extends Base\AbstractCollectionReadTest
{
    protected function make($data)
    {
        return new Collection($data);
    }
}
