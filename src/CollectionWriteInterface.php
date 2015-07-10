<?php


namespace Nayjest\Collection;


interface CollectionWriteInterface
{
    public function addItem($item, $prepend = false);

    public function addItems($items, $prepend = false);

    public function clear();

    public function remove($item);

    public function setItems($items);

}