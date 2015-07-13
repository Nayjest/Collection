<?php

namespace Nayjest\Collection;

/**
 * Class Collection
 *
 * Basic collection implementation.
 *
 */
class Collection implements CollectionInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use CollectionWriteTrait;
}
