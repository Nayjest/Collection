<?php

namespace Nayjest\Collection\Extended;

use Nayjest\Manipulator\Manipulator;

/**
 * Implementation of methods added in ObjectCollectionReadInterface.
 *
 * ObjectCollectionTrait requires implementation of \Nayjest\Collection\CollectionReadInterface.
 */
trait ObjectCollectionTrait
{

    abstract public function find(callable $callback, array $optionalArguments = null);

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
     * @param $propertyName
     * @return static
     */
    public function sortByProperty($propertyName)
    {

        return $this->sort(function ($itemA, $itemB) use ($propertyName) {
            $a = Manipulator::getValue($itemA, $propertyName, 0);
            $b = Manipulator::getValue($itemB, $propertyName, 0);
            if ($a < $b) {
                return -1;
            }
            return ($a > $b) ? 1 : 0;
        });
    }

    private function getPropertyComparator($propertyName, $value, $useGetters)
    {
        $methodName = $useGetters ? 'get' . (string)(\Stringy\create($propertyName)->upperCamelize()) : false;

        return function ($item) use ($propertyName, $value, $methodName) {
            return (
                isset($item->{$propertyName})
                && $item->{$propertyName} === $value
            ) || (
                $methodName !== false
                && method_exists($item, $methodName)
                && call_user_func([$item, $methodName]) === $value
            );

        };
    }
}
