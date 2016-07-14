<?php

namespace Nayjest\Collection\Test;

use ArrayIterator;
use Nayjest\Collection\Exception\InvalidCollectionElementsException;
use Nayjest\Collection\IteratorCollection;
use Nayjest\Collection\Test\Base\TestFileIteratorReadTrait;
use SplFileObject;

class IteratorCollectionReadTest extends Base\AbstractCollectionReadTest
{
    use TestFileIteratorReadTrait;

    protected function make($data)
    {
        if (is_array($data)) {
            $data = new ArrayIterator($data);
        }
        if (!$data instanceof \Traversable) {
            throw new InvalidCollectionElementsException;
        }
        return new IteratorCollection($data);
    }
}
