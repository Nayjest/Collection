<?php

namespace Nayjest\Collection\Extended;

use Evenement\EventEmitterTrait;
use Nayjest\Collection\CollectionDataTrait;
use Nayjest\Collection\CollectionReadTrait;

class Registry implements RegistryInterface
{
    use CollectionDataTrait;
    use CollectionReadTrait;
    use ObjectCollectionTrait;
    use EventEmitterTrait;

    public function __construct(array $items = [])
    {
        $this->setMany($items);
    }

    /**
     * @param string $key
     * @param object $item
     * @return $this
     */
    public function set($key, $item)
    {
        $this->emit('change', [$key, $item, $this]);
        $this->items()[$key] = $item;
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeByKey($key)
    {
        $items = &$this->items();
        if (array_key_exists($key, $items)) {
            $this->emit('change', [$key, null, $this]);
            unset($items[$key]);
        }
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
     * @param string $key
     * @return bool
     */
    public function hasKey($key)
    {
        $keyExists = array_key_exists($key, $this->items());
        return $keyExists && $this->items()[$key] !== null;
    }

    /**
     * @param string $key
     * @return null|object
     */
    public function get($key)
    {
        return $this->hasKey($key) ? $this->items()[$key] : null;
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
