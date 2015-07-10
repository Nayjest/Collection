<?php
namespace Nayjest\Collection;

class ObjectCollection implements CollectionInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use CollectionWriteTrait;

    public function findByType($className)
    {
        return $this->filter('is_a', [$className]);
    }
}