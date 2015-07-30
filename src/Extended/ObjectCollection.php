<?php

namespace Nayjest\Collection\Extended;
use Nayjest\Collection\CollectionInterface;
use Nayjest\Collection\CollectionTrait;

/**
 * Class ObjectCollection.
 *
 * Collection of objects.
 */
class ObjectCollection implements CollectionInterface
{
    use CollectionTrait;
    use ObjectCollectionTrait;
}
