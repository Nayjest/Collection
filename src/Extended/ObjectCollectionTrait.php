<?php

namespace Nayjest\Collection\Extended;

trait ObjectCollectionTrait
{

    abstract public function find(callable $callback, array $optionalArguments = null);

    abstract public function filter(callable $callback, array $optionalArguments = null);

    /**
     * @param string $className
     *
     * @return static
     */
    public function findByType($className)
    {
        return $this->find('is_a', [$className]);
    }

    public function filterByType($className)
    {
        return $this->filter('is_a', [$className]);
    }

    public function filterByProperty($propertyName, $value)
    {
        return $this->filter(
            $this->getPropertyComparator($propertyName, $value)
        );
    }

    public function findByProperty($propertyName, $value)
    {
        return $this->find(
            $this->getPropertyComparator($propertyName, $value)
        );
    }

    private function getPropertyComparator($propertyName, $value)
    {
        return function ($item) use ($propertyName, $value)
        {
            return isset($item->{$propertyName})
            && $item->{$propertyName} === $value;
        };
    }
}
