<?php

namespace Nayjest\Collection;

/**
 * Class ReadonlyGroupedCollection
 *
 * @draft
 *
 * @property GroupedCollection $collection
 */
class ReadonlyGroupedCollection extends ReadonlyDecorator
{
    public function getGroups()
    {
        return $this->collection->getGroups();
    }

    /**
     * @param string $groupName
     * @return bool
     */
    public function hasGroup($groupName)
    {
        return $this->collection->hasGroup($groupName);

    }

    public function getByGroups()
    {
        return $this->collection->getByGroups();
    }

    public function getByGroup($group)
    {
        return $this->collection->getByGroup($group);
    }
}