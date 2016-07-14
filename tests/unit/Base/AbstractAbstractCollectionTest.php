<?php

namespace Nayjest\Collection\Test\Base;

use Nayjest\Collection\CollectionInterface;
use PHPUnit_Framework_TestCase;

abstract class AbstractCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CollectionInterface
     */
    protected $collection;

    /**
     * @param $data
     *
     * @return CollectionInterface
     */
    abstract protected function make($data);
    protected final function fixture()
    {
        return [1,2,3,4,5];
    }

    public function setUp()
    {
        $this->collection = $this->make($this->fixture());
    }
}
