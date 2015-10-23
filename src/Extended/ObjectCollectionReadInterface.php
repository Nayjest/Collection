<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionReadInterface;

/**
 * Collection read interface with additional methods for working with collection of objects.
 */
interface ObjectCollectionReadInterface extends CollectionReadInterface
{

    public function findByType($className);

    public function filterByType($className);

    public function filterByProperty($propertyName, $value);

    public function findByProperty($propertyName, $value);

    public function sortByProperty($propertyName);
}
