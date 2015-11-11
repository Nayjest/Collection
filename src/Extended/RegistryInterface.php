<?php

namespace Nayjest\Collection\Extended;


interface RegistryInterface extends ObjectCollectionReadInterface
{
    /**
     * @param string $key
     * @param object|null $item
     * @return $this
     */
    public function set($key, $item);

    /**
     * @param array $items
     * @return $this
     */
    public function setMany(array $items);

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey($key);

    /**
     * @param string $key
     * @return null|object
     */
    public function get($key);

    public function onChange(callable $callback);
}