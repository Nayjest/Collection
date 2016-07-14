<?php

namespace Nayjest\Collection;

use Nayjest\Collection\Common\Utils;
use Nayjest\Collection\Exception\InvalidCollectionElementsException;
use Nayjest\Collection\Exception\NotArrayOrTraversableException;
use Nayjest\Collection\Implementation\MethodAliasesTrait;
use Nayjest\Collection\Implementation\Read\ObjectCollectionReadTrait;
use Nayjest\Collection\Implementation\Read\ReadFromArrayTrait;
use Nayjest\Collection\Implementation\Write\ArrayCollectionWriteTrait;
use Traversable;

class Collection implements CollectionInterface
{
    use ReadFromArrayTrait;
    use ArrayCollectionWriteTrait;
    use MethodAliasesTrait;
    use ObjectCollectionReadTrait;

    public static function make($data)
    {
        return new static($data);
    }

    /**
     * Constructor.
     *
     * @param array|Traversable $data
     */
    public function __construct($data = [])
    {
        $this->initialize($data);
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
        $collection = new static($data);
        return $collection;
    }

    protected function initialize($data)
    {
        try {
            $this->data = Utils::toArray($data);
        } catch (NotArrayOrTraversableException $e) {
            $message = 'Trying to initialize collection with invalid elements';
            throw new InvalidCollectionElementsException($message, 0, $e);
        }
    }
}
