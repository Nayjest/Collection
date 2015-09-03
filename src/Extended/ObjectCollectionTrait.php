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

    public function filterByProperty($propertyName, $value, $useGetters = false)
    {
        return $this->filter(
            $this->getPropertyComparator($propertyName, $value, $useGetters)
        );
    }

    public function findByProperty($propertyName, $value, $useGetters = false)
    {
        return $this->find(
            $this->getPropertyComparator($propertyName, $value, $useGetters)
        );
    }

    private function getPropertyComparator($propertyName, $value, $useGetters)
    {
        $methodName = $useGetters ? 'get' . (string)(\Stringy\create($propertyName)->upperCamelize()) : false;

        return function ($item) use ($propertyName, $value, $methodName)
        {
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
