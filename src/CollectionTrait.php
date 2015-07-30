<?php

namespace Nayjest\Collection;

trait CollectionTrait
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use CollectionWriteTrait {
        CollectionWriteTrait::createCollection
        insteadof CollectionReadTrait;
    }
    use CollectionConstructorTrait;
}
