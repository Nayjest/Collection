<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Extended\ObjectCollection;
use PHPUnit_Framework_TestCase;

class ObjWithGetter
{
    private $val;
    public function __construct($val)
    {
        $this->val = $val;
    }
    public function getTestProp()
    {
        return $this->val;
    }
}

class ObjectCollectionTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $i1 = (object)['test_prop'=>1];
        $i2 = new ObjWithGetter(2);
        $i3 = (object)['other_prop' => 2];
        $i4 = new ObjWithGetter(1);
        $i5 = (object)['test_prop'=>2];
        $i6 = (object)['test_prop'=>2, 'other'=>3];

        $collection = new ObjectCollection([$i1, $i2, $i3, $i4, $i5, $i6]);

        $res = $collection->findByProperty('test_prop', 2);
        self::assertEquals($i5, $res);

        $res = $collection->findByProperty('test_prop', 2, true);
        self::assertEquals($i2, $res);

        $res = $collection->findByProperty('test_prop', 3, true);
        self::assertEquals(null, $res);

        $res = $collection->findByProperty('test_prop', '2', true);
        self::assertEquals(null, $res);

        $res = $collection->filterByProperty('test_prop', 2, true);
        self::assertEquals(3, count($res));

        $res = $collection->filterByProperty('test_prop', 2, false);
        self::assertEquals(2, count($res));
    }
}
