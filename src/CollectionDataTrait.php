<?php

namespace Nayjest\Collection;

trait CollectionDataTrait
{
    private $data = [];

    protected function &items()
    {
        return $this->data;
    }
}