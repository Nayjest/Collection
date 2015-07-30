<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;

class CollectionWriteTest extends AbstractCollectionTest
{
    protected function makeCollection($data)
    {
        return new Collection($data);
    }

    public function testAddItem()
    {
        self::assertFalse($this->collection->contains(989));
        $res = $this->collection->add(989);
        self::assertEquals($this->collection, $res);
        self::assertTrue($this->collection->contains(989));
    }

    public function testRemoveItem()
    {
        $item = $this->fixture()[0];
        self::assertTrue($this->collection->contains($item));
        $res = $this->collection->remove($item);
        self::assertEquals($this->collection, $res);
        self::assertFalse($this->collection->contains($item));
    }
}
