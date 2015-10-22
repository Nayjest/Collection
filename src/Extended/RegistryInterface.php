<?php

namespace Nayjest\Collection\Extended;


interface RegistryInterface extends ObjectCollectionReadInterface
{
    /**
     * @param string $name
     * @param object|null $item
     * @return $this
     */
    public function set($name, $item);

    /**
     * @param array $items
     * @return $this
     */
    public function setMany(array $items);

    /**
     * @param string $itemName
     * @return bool
     */
    public function has($itemName);

    /**
     * @param string $itemName
     * @return null|object
     */
    public function get($itemName);

    public function onChange(callable $callback);
}