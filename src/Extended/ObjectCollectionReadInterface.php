<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionReadInterface;

/**
 * Collection read interface with additional methods for working with collection of objects.
 */
interface ObjectCollectionReadInterface extends CollectionReadInterface
{

    public function findByType($className);

    /**
     * Filters collection elements by (parent)class or interface.
     * @see is_a
     *
     * @param string $className
     * @return self
     */
    public function filterByType($className);

    /**
     * @param string $propertyName
     * @param $value
     * @return self
     */
    public function filterByProperty($propertyName, $value);

    public function findByProperty($propertyName, $value);

    /**
     * @param string $propertyName
     * @return self
     */
    public function sortByProperty($propertyName);
}
