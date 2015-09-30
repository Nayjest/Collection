<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionTrait;

/**
 * Collection of objects.
 *
 * ObjectCollection implements additional methods for working with collection of objects.
 */
class ObjectCollection implements ObjectCollectionInterface
{
    use CollectionTrait;
    use ObjectCollectionTrait;
}
