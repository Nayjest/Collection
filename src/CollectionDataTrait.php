<?php

namespace Nayjest\Collection;

trait CollectionDataTrait
{
    /** @var array  */
    private $data = [];

    /**
     * Returns reference to array storing collection items.
     *
     * @return array
     */
    protected function &items()
    {
        return $this->data;
    }
}
