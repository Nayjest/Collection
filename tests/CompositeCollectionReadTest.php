<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;
use Nayjest\Collection\Decorator\CompositeCollection;

class CompositeCollectionReadTest extends AbstractCollectionReadTest
{
    protected function makeCollection($data)
    {
        $c1 = new Collection();
        $c2 = new Collection($data);
        $c3 = new Collection();
        $res = new CompositeCollection();
        $res->setCollections([$c1, $c2, $c3]);

        return $res;
    }
}
