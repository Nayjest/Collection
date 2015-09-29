<?php

namespace Nayjest\Collection\Test;

abstract class AbstractCollectionReadTest extends AbstractCollectionTest
{
    public function testIterator()
    {
        $res = [];
        foreach ($this->collection as $v) {
            $res[] = $v;
        }
        self::assertEquals($this->fixture(), $res);
    }

    public function testFirst()
    {
        self::assertEquals($this->fixture()[0], $this->collection->first());
    }

    public function testToArray()
    {
        $res = $this->collection->toArray();
        self::assertEquals($this->fixture(), $res);
    }

    public function testIsEmpty()
    {
        self::assertEquals(false, $this->collection->isEmpty());
        self::assertEquals(true, $this->makeCollection([])->isEmpty());
    }

    public function testContains()
    {
        self::assertEquals(false, $this->collection->contains(254246758));
        self::assertEquals(true, $this->collection->contains($this->fixture()[0]));
    }

    public function testFilter()
    {
        $odd = function ($var) { return($var & 1); };
        $res = $this->collection->filter($odd)->toArray();
        sort($res);
        $test = array_filter($this->fixture(), $odd);
        sort($test);
        self::assertEquals(
            $test,
            $res
        );

        $odd = function ($var, $arg2) {
            return $arg2 === 7 ? ($var & 1) : false;
        };

        $res = $this->collection->filter($odd, [7])->toArray();
        sort($res);
        self::assertEquals(
            $test,
            $res
        );

        $res = $this->collection->filter($odd, [8])->toArray();
        sort($res);
        self::assertNotEquals(
            $test,
            $res
        );
    }

    public function testFind()
    {
        $even = function ($var) { return(!($var & 1)); };
        $res = $this->collection->find($even);
        self::assertEquals(2, $res);
    }

    public function testRandom()
    {
        $item = $this->collection->random();
        self::assertTrue($item >= min($this->fixture()) && $item <= max($this->fixture()));

        $emptyCollection = $this->makeCollection([]);
        self::assertNull($emptyCollection->random());
    }

    public function testCount()
    {
        self::assertEquals(count($this->fixture()), count($this->collection));
        self::assertEquals(count($this->fixture()), $this->collection->count());
        self::assertEquals(0, $this->makeCollection([])->count());
    }
}
