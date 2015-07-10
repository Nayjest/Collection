<?php

namespace Nayjest\Collection;

/**
 * Class GroupedCollection
 * @draft
 */
class GroupedCollection extends Collection
{
    use HasGroupsTrait;

    public function setByGroups(array $groupedItems, $updateGroups = false)
    {
        if ($updateGroups) {
            $this->addGroups(array_keys($groupedItems));
        }
        foreach ($groupedItems as $group => $items) {
            foreach ($items as $item) {
                $this->add($item, false, $group);
            }
        }
    }

    public function add($item, $prepend = false, $group = null)
    {
        $this->addToGroup($item, $prepend, $group);
        return parent::add($item, $prepend);
    }

    public function remove($item)
    {
        $this->removeFromGroups($item);
        return parent::remove($item);
    }

    public function clear()
    {
        parent::clear();
        $this->clearGroups();
        return $this;
    }
}
