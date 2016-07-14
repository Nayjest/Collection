<?php

namespace Nayjest\Collection\Implementation\Read;

use ArrayAccess;
use ArrayIterator;
use CallbackFilterIterator;
use Countable;
use IteratorAggregate;
use LimitIterator;
use Nayjest\Collection\Common\MapIterator;
use Nayjest\Collection\Common\Utils;
use OutOfBoundsException;
use SeekableIterator;

trait SmartReadTrait
{
    protected $isArray;

    protected $isLazy;

    abstract protected function createCollection($data);

    public function toArray()
    {
        return $this->isArray ? $this->data : iterator_to_array($this->data, true);
    }

    public function first()
    {
        if ($this->isArray) {
            return reset($this->data);
        } else {
            foreach ($this->data as $value) {
                return $value;
            }
            return false;
        }
    }

    public function last()
    {
        if ($this->isArray) {
            return end($this->data);
        } else {
            $item = false;
            foreach ($this->data as $item) {
            }
            return $item;
        }
    }

    public function hasKey($key)
    {
        if ($this->isArray) {
            return array_key_exists($key, $this->data);
        } elseif ($this->data instanceof ArrayAccess) {
            {
                # Fix "Illegal offset type" error for null
                if ($key === null) {
                    $key = '';
                }
                return $this->data->offsetExists($key);
            }
        } else {
            foreach ($this->data as $currentKey => $value) {
                if ($key === $currentKey) {
                    return true;
                }
            }
            return false;
        }
    }

    public function has($item)
    {
        if ($this->isArray) {
            return in_array($item, $this->data, true);
        } else {
            foreach ($this->data as $current) {
                if ($current === $item) {
                    return true;
                }
            }
            return false;
        }
    }

    public function indexOf($item)
    {
        if ($this->isArray) {
            return array_search($item, $this->data, true);
        } else {
            foreach ($this->data as $key => $value) {
                if ($value === $item) {
                    return $key;
                }
            }
            return false;
        }
    }

    public function get($key, $default = null)
    {
        if ($this->isArray) {
            return isset($this->data[$key]) ? $this->data[$key] : $default;
        } elseif ($this->data instanceof ArrayAccess) {
            return $this->data->offsetExists($key)
                ? $this->data->offsetGet($key)
                : $default;
        } elseif ($this->data instanceof SeekableIterator && is_int($key)) {
            // experimental
            try {
                $this->data->seek($key);
                if ($this->data->key() === $key) {
                    return $this->data->current();
                }
            } catch (OutOfBoundsException $e) {
            }
        }
        $data = iterator_to_array($this->data);
        return isset($data[$key]) ? $data[$key] : $default;
    }

    public function getKeys()
    {
        if ($this->isArray) {
            return array_keys($this->data);
        } else {
            return array_keys(iterator_to_array($this->data, true));
        }
    }

    public function getValues()
    {
        if ($this->isArray) {
            return array_values($this->data);
        } else {
            return array_values(iterator_to_array($this->data, false));
        }
    }

    public function count()
    {
        return ($this->isArray || $this->data instanceof Countable)
            ? count($this->data)
            : iterator_count($this->data);
    }

    public function isEmpty()
    {
        if ($this->isArray) {
            return empty($this->data);
        } else {
            return $this->count() === 0;
        }
    }

    public function getIterator()
    {
        if ($this->isArray) {
            return new ArrayIterator($this->data);
        }
        return $this->data instanceof IteratorAggregate ? $this->data->getIterator() : $this->data;

    }

    public function map(callable $callback, array $arguments = null)
    {
        $callback =  Utils::bindArguments($callback, $arguments);
        $data = $this->isArray && !$this->isLazy
            ? array_map($callback, $this->data)
            : new MapIterator($this->getIterator(), $callback);
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

    public function filter(callable $callback, array $arguments = null)
    {
        $callback = Utils::bindArguments($callback, $arguments);
        $data = $this->isArray && !$this->isLazy
            ? array_filter($this->data, $callback)
            : new CallbackFilterIterator($this->getIterator(), $callback);
        return $this->createCollection($data);
    }

    public function slice($offset, $length = null)
    {
        if ($this->isArray && !$this->isLazy) {
            $data = array_slice($this->data, $offset, $length, true);
        } else {
            $data = new LimitIterator($this->getIterator(), $offset, $length);
        }
        return $this->createCollection($data);
    }

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
        $data = $this->toArray();
        if (empty($data)) {
            return null;
        }
        $index = array_rand($data, 1);
        return $index === null ? null : $data[$index];
    }
}

