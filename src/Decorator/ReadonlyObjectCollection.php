<?php

namespace Nayjest\Collection\Decorator;

use Nayjest\Collection\Extended\ObjectCollectionReadInterface;
use Nayjest\Collection\Extended\ObjectCollectionTrait;

/**
 * Collection wrapper that allows only operations for data reading.
 */
class ReadonlyObjectCollection extends ReadonlyCollection
    implements ObjectCollectionReadInterface
{
    use ObjectCollectionTrait;
}
