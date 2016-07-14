<?php

namespace Nayjest\Collection;

use Nayjest\Collection\Exception\InvalidCollectionElementsException;
use Nayjest\Collection\Implementation\Read\ObjectCollectionReadTrait;
use Nayjest\Collection\Implementation\Read\ReadMethodAliasesTrait;
use Nayjest\Collection\Implementation\Read\ReadonlyArrayAccessExceptionsTrait;
use Nayjest\Collection\Implementation\Read\SmartReadTrait;
use Traversable;

class SmartCollection implements CollectionReadInterface
{
    use SmartReadTrait;
    use ReadonlyArrayAccessExceptionsTrait;
    use ReadMethodAliasesTrait;
    use ObjectCollectionReadTrait;

    const LAZY = 1;

    private $data;

    public function __construct($data = [], $flags = self::LAZY)
    {
        if (is_array($data)) {
            $this->isArray = true;
        } elseif (!$data instanceof Traversable) {
            $message = 'Trying to initialize collection with invalid elements';
            throw new InvalidCollectionElementsException($message);
        }
        $this->isLazy = $flags & self::LAZY;
        $this->data = $data;
    }

    /**
     * Creates collection of items.
     *
     * This method is used inside data manipulation methods of immutable collection
     * to produce new instances initialized by processed data.
     *
     * Override it if:
     * 1) derived collection requires specific initialization.
     * 2) derived collection should create immutable collections of another type when processing it.
     *
     * @param $data
     *
     * @return static
     */
    protected function createCollection($data)
    {
        $flags = $this->isLazy ? self::LAZY : 0;
        $collection = new static($data, $flags);
        return $collection;
    }
}