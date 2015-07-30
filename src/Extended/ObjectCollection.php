<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionTrait;

/**
 * Class ObjectCollection.
 *
 * Collection of objects.
 */
class ObjectCollection implements ObjectCollectionInterface
{
    use CollectionTrait;
    use ObjectCollectionTrait;
}
