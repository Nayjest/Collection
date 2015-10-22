<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;
use Nayjest\Collection\CollectionInterface;

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

    public function testEvents()
    {
        $onChangeCalls = 0;
        $onItemAddCalls = 0;
        $onItemRemoveCalls = 0;
        $lastItem = null;
        $this->collection->onChange(function (CollectionInterface $collection) use (&$onChangeCalls) {
            $onChangeCalls++;
        });
        $this->collection->onItemAdd(function ($item, CollectionInterface $collection) use (&$onItemAddCalls, &$lastItem) {
            $onItemAddCalls++;
            $lastItem = $item;
        });
        $this->collection->onItemRemove(function ($item, CollectionInterface $collection) use (&$onItemRemoveCalls, &$lastItem) {
            $onItemRemoveCalls++;
            $lastItem = $item;
        });

        $this->collection->set([11,12,13,14,15,16]);
        self::assertEquals(1, $onChangeCalls);
        self::assertEquals(6, $onItemAddCalls);
        self::assertEquals(5, $onItemRemoveCalls);

        $this->collection->remove(11);
        $this->collection->remove(12);
        self::assertEquals(3, $onChangeCalls);
        self::assertEquals(7, $onItemRemoveCalls);
        self::assertEquals(12, $lastItem);

        $this->collection->add(8);
        self::assertEquals(4, $onChangeCalls);
        self::assertEquals(7, $onItemAddCalls);
        self::assertEquals(8, $lastItem);

    }
}
