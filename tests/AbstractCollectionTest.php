<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Collection;
use Nayjest\Collection\CollectionReadInterface;
use PHPUnit_Framework_TestCase;

abstract class AbstractCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @param $data
     *
     * @return CollectionReadInterface
     */
    abstract protected function makeCollection($data);
    protected final function fixture()
    {
        return [1,2,3,4,5];
    }

    public function setUp()
    {
        $this->collection = $this->makeCollection($this->fixture());
    }
}
