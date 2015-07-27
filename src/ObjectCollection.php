<?php

namespace Nayjest\Collection;

/**
 * Class ObjectCollection.
 *
 * Collection of objects.
 */
class ObjectCollection implements CollectionInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use CollectionWriteTrait;

    /**
     * @param string $className
     *
     * @return static
     */
    public function findByType($className)
    {
        return $this->find('is_a', [$className]);
    }
}
