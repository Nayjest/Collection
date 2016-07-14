<?php


namespace Nayjest\Collection;

use ArrayAccess;
use CallbackFilterIterator;
use Countable;
use Generator;
use IteratorAggregate;
use LimitIterator;
use Nayjest\Collection\Common\MapIterator;
use Nayjest\Collection\Common\Utils;
use Nayjest\Collection\Implementation\Read\ObjectCollectionReadTrait;
use Nayjest\Collection\Implementation\Read\ReadUsingForeachTrait;
use Nayjest\Collection\Implementation\Read\ReadMethodAliasesTrait;
use Nayjest\Collection\Implementation\Read\ReadonlyArrayAccessExceptionsTrait;
use OutOfBoundsException;
use SeekableIterator;
use Traversable;

class IteratorCollection implements CollectionReadInterface
{
    use ReadMethodAliasesTrait;
    use ObjectCollectionReadTrait;
    use ReadonlyArrayAccessExceptionsTrait;
    use ReadUsingForeachTrait {
        ReadUsingForeachTrait::hasKey as private hasKeyForeachImplementation;
    }
    /**
     * An array containing the entries of this collection.
     *
     * @var Traversable
     */
    private $data;

    /**
     * Constructor.
     *
     * @param Traversable|null $data
     */
    public function __construct(Traversable $data)
    {
        // Generators support
        if ($data instanceof Generator) {
            $data = new Common\GeneratorCachingIterator($data);
        }
        $this->data = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return iterator_to_array($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function hasKey($key)
    {
        if ($this->data instanceof ArrayAccess) {
            # Fix "Illegal offset type" error for null
            if ($key === null) {
                $key = '';
            }
            return $this->data->offsetExists($key);
        }
        return $this->hasKeyForeachImplementation($key);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        // @todo requires optimisations
        if ($this->data instanceof ArrayAccess) {
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

    /**
     * {@inheritDoc}
     */
    public function getKeys()
    {
        return array_keys(iterator_to_array($this->data, true));
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        // @todo requires optimisations
        return array_values(iterator_to_array($this->data, false));
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return $this->data instanceof Countable
            ? count($this->data)
            : iterator_count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return $this->data instanceof IteratorAggregate ? $this->data->getIterator() : $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function map(callable $callback, array $arguments = null)
    {
        $callback = Utils::bindArguments($callback, $arguments);
        return $this->createCollection(new MapIterator($this->data, $callback));
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
        $callback = Utils::bindArguments($callback, $arguments);
        $iterator = new CallbackFilterIterator(
            $this->getIterator(), $callback
        );
        return $this->createCollection($iterator);
    }


    /**
     * {@inheritDoc}
     */
    public function slice($offset, $length = null)
    {
        $iterator = new LimitIterator($this->data, $offset, $length);
        return $this->createCollection($iterator);
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
        $data = $this->toArray();
        if (empty($data)) {
            return null;
        }
        $index = array_rand($data, 1);
        return $index === null ? null : $data[$index];
    }

    /**
     * Creates collection of items.
     *
     * This method is used inside data manipulation methods of immutable collection
     * to produce new instances initialized by processed data.
     *
     * Override it if:
     * 1) derived collection requires specific initialization.
     * 2) derived collection should create immutable collections of another type when processing it.
     *
     * @param $data
     *
     * @return static
     */
    protected function createCollection($data)
    {
        $collection = new static($data);
        return $collection;
    }
}
