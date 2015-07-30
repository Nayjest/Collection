<?php

namespace Nayjest\Collection\Test;

use Nayjest\Collection\Extended\LazyLoadCollection;
use RuntimeException;

class LazyLoadCollectionReadTest extends AbstractCollectionReadTest
{
    private $initializerCalled;
    protected function makeCollection($data)
    {
        $this->initializerCalled = false;

        return new LazyLoadCollection(function () use ($data) {
            if ($this->initializerCalled) {
                throw new RuntimeException('Initializer called more than once.');
            }
            $this->initializerCalled = true;

            return $data;
        });
    }
}
