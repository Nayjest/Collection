<?php

namespace Nayjest\Collection\Implementation\Read;

use Nayjest\Collection\CollectionInterface;

/**
 * @property CollectionInterface $data
 */
trait ReadWrapperTrait
{
    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->data->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return $this->data->first();
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return $this->data->last();
    }

    public function hasKey($key)
    {
        return $this->data->hasKey($key);
    }

    /**
     * {@inheritDoc}
     */
    public function has($item)
    {
        return $this->data->has($item);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($item)
    {
        return $this->data->indexOf($item);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return $this->data->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function getKeys()
    {
        return $this->data->getKeys();
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        return $this->data->getValues();
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return $this->data->count();
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return $this->data->isEmpty();
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return $this->data->getIterator();
    }

    /**
     * {@inheritDoc}
     */
    public function map(callable $callback, array $arguments = null)
    {
        return $this->data->map($callback, $arguments);
    }

    public function find(callable $callback, array $arguments = null)
    {
        return $this->data->find($callback, $arguments);
    }

    /**
     * {@inheritDoc}
     */
    public function filter(callable $callback, array $arguments = null)
    {

        return $this->data->filter($callback, $arguments);
    }


    /**
     * {@inheritDoc}
     */
    public function slice($offset, $length = null)
    {
        return $this->data->slice($offset, $length);
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
        return $this->data->sort($compareFunction);
    }

    /**
     * @return mixed|null
     */
    public function random()
    {
        return $this->data->random();
    }

}