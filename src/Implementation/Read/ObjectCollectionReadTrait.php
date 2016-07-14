<?php

namespace Nayjest\Collection\Implementation\Read;

use mp;

/**
 * Methods for working with collections of objects are grouped to this trait.
 */
trait ObjectCollectionReadTrait
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
     * @return static
     */
    public function filterByProperty($propertyName, $value)
    {
        return $this->filter(
            self::makePropertyComparator($propertyName, $value)
        );
    }

    /**
     * @param string $propertyName
     * @param $value
     * @return mixed
     */
    public function findByProperty($propertyName, $value)
    {
        return $this->find(
            self::makePropertyComparator($propertyName, $value)
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
        foreach ($this as $item) {
            $key = mp\getValue($item, $propertyName);
            if ($key) {
                $results[$key] = $item;
            }
        }
        return $results;
    }

    private static function makePropertyComparator($propertyName, $value)
    {
        return function ($item) use ($propertyName, $value) {
            // NAN used as default because NAN !== NAN
            return mp\getValue($item, $propertyName, NAN) === $value;
        };
    }
}