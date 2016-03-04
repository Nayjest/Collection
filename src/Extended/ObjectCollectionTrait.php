<?php

namespace Nayjest\Collection\Extended;

use mp;

/**
 * Implementation of methods added in ObjectCollectionReadInterface.
 *
 * ObjectCollectionTrait requires implementation of \Nayjest\Collection\CollectionReadInterface.
 */
trait ObjectCollectionTrait
{

    /**
     * @param callable $callback
     * @param array|null $optionalArguments
     * @return static
     */
    abstract public function find(callable $callback, array $optionalArguments = null);

    /**
     * @param callable $callback
     * @param array|null $optionalArguments
     * @return static
     */
    abstract public function filter(callable $callback, array $optionalArguments = null);

    abstract public function toArray();

    /**
     * @param callable $compareFunction
     * @return static
     */
    abstract public function sort(callable $compareFunction);

    /**
     * @param string $className
     *
     * @return mixed
     */
    public function findByType($className)
    {
        return $this->find('is_a', [$className]);
    }

    /**
     * @param string $className
     * @return static
     */
    public function filterByType($className)
    {
        return $this->filter('is_a', [$className]);
    }

    /**
     * @param string $propertyName
     * @param $value
     * @param bool $useGetters
     * @return static
     */
    public function filterByProperty($propertyName, $value, $useGetters = false)
    {
        return $this->filter(
            $this->getPropertyComparator($propertyName, $value, $useGetters)
        );
    }

    /**
     * @param string $propertyName
     * @param $value
     * @param bool $useGetters
     * @return mixed
     */
    public function findByProperty($propertyName, $value, $useGetters = false)
    {
        return $this->find(
            $this->getPropertyComparator($propertyName, $value, $useGetters)
        );
    }

    /**
     * @param string $propertyName
     * @return static
     */
    public function sortByProperty($propertyName)
    {

        return $this->sort(function ($itemA, $itemB) use ($propertyName) {
            $a = mp\getValue($itemA, $propertyName, 0);
            $b = mp\getValue($itemB, $propertyName, 0);
            if ($a < $b) {
                return -1;
            }
            return ($a > $b) ? 1 : 0;
        });
    }

    private function getPropertyComparator($propertyName, $value, $useGetters)
    {
        if ($useGetters) {
            return function ($item) use ($propertyName, $value) {
                // NAN used as default because NAN !== NAN
                return mp\getValue($item, $propertyName, NAN) === $value;
            };
        } else {
            return function ($item) use ($propertyName, $value) {
                return isset($item->{$propertyName}) && $item->{$propertyName} === $value;
            };
        }
    }

    /**
     * Returns array indexed by specified property of collection elements.
     * If there is few elements with same property value, last will be used.
     *
     * @param string $propertyName
     * @return array|object[]
     */
    public function indexByProperty($propertyName)
    {
        $results = [];
        foreach ($this->toArray() as $item) {
            $key = mp\getValue($item, $propertyName);
            if ($key) {
                $results[$key] = $item;
            }
        }
        return $results;
    }
}
