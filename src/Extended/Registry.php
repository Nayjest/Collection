<?php

namespace Nayjest\Collection\Extended;

use Evenement\EventEmitterTrait;
use Nayjest\Collection\CollectionDataTrait;
use Nayjest\Collection\CollectionReadTrait;

class Registry implements ObjectCollectionReadInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use ObjectCollectionTrait;
    use EventEmitterTrait;

    public function __construct(array $items = [])
    {
        foreach ($items as $name => $item) {
            $this->set($name, $item);
        }
    }

    /**
     * @param string $name
     * @param object|null $item
     * @return $this
     */
    public function set($name, $item)
    {
        $this->emit('change', [$name, $item, $this]);
        $this->items()[$name] = $item;
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function setMany(array $items)
    {
        foreach ($items as $name => $item) {
            $this->set($name, $item);
        }
        return $this;
    }

    /**
     * @param string $itemName
     * @return bool
     */
    public function has($itemName)
    {
        $keyExists = array_key_exists($itemName, $this->items());
        return $keyExists && $this->items()[$itemName] !== null;
    }


    /**
     * @param string $itemName
     * @return null|object
     */
    public function get($itemName)
    {
        return $this->has($itemName) ? $this->items()[$itemName] : null;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function onChange(callable $callback)
    {
        $this->on('change', $callback);
        return $this;
    }
}
