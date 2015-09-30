<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Collection\CollectionTrait;
use Nayjest\Collection\Exceptions\InvalidItemException;

/**
 * Base class for typed collections.
 */
abstract class AbstractTypedObjectCollection implements ObjectCollectionInterface
{
    use CollectionTrait {
        CollectionTrait::add as protected addWithoutCheck;
    }
    use ObjectCollectionTrait;

    /**
     * @return string[]
     */
    abstract protected function getAllowedItemTypes();

    /**
     * @param $item
     * @return bool
     */
    protected function checkType($item)
    {
        foreach ($this->getAllowedItemTypes() as $className) {
            if ($item instanceof $className) {
                return true;
            }
        }
        throw new InvalidItemException($item, $this->getAllowedItemTypes());
    }

    public function add($item, $prepend = false)
    {
        $this->checkType($item);
        return $this->addWithoutCheck($item, $prepend);
    }
}
