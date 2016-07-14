<?php

namespace Nayjest\Collection\Implementation\Read;

use ArrayIterator;
use Nayjest\Collection\CollectionReadInterface;
use Nayjest\Collection\Common\Utils;

trait ReadFromArrayTrait
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    protected $data;

    abstract protected function createCollection($data);

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return reset($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return end($this->data);
    }

    public function hasKey($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function has($item)
    {
        return in_array($item, $this->data, true);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($item)
    {
        return array_search($item, $this->data, true);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getKeys()
    {
        return array_keys($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        return array_values($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function map(callable $callback, array $arguments = null)
    {
        $data = array_map(
            Utils::bindArguments($callback, $arguments),
            $this->data
        );
        return $this->createCollection($data);
    }

    public function find(callable $callback, array $arguments = null)
    {
        $callback = Utils::bindArguments($callback, $arguments);
        foreach ($this->data as $item) {
            if (call_user_func($callback, $item)) {
                return $item;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(callable $callback, array $arguments = null)
    {

        $data = array_filter(
            $this->data,
            Utils::bindArguments($callback, $arguments)
        );
        return $this->createCollection($data);
    }


    /**
     * {@inheritDoc}
     */
    public function slice($offset, $length = null)
    {
        return $this->createCollection(array_slice($this->data, $offset, $length, true));
    }

    /**
     * Sorts collection items.
     *
     * This method preserves key order (stable sort) using Schwartzian Transform.
     * @see http://stackoverflow.com/questions/4353739/preserve-key-order-stable-sort-when-sorting-with-phps-uasort
     * @see http://en.wikipedia.org/wiki/Schwartzian_transform
     *
     * @param callable $compareFunction
     * @return CollectionReadInterface|static new collection with sorted items.
     */
    public function sort(callable $compareFunction)
    {
        $items = $this->toArray();

        # Sorting with Schwartzian Transform
        # If stable sort is not required,
        # following code can be replaced to usort($items, $compareFunction);
        $index = 0;
        foreach ($items as &$item) {
            $item = [$index++, $item];
        }
        usort($items, function ($a, $b) use ($compareFunction) {
            $result = call_user_func($compareFunction, $a[1], $b[1]);
            return $result == 0 ? $a[0] - $b[0] : $result;
        });
        foreach ($items as &$item) {
            $item = $item[1];
        }
        # End of sorting with Schwartzian Transform

        return $this->createCollection($items);
    }

    /**
     * @return mixed|null
     */
    public function random()
    {
        if (empty($this->data)) {
            return null;
        }
        $index = array_rand($this->data, 1);
        return $this->data[$index];
    }
}
