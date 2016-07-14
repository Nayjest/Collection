<?php

namespace Nayjest\Collection\Common;

use Generator;
use Iterator;

class GeneratorCachingIterator implements Iterator
{
    const PRESERVE_KEYS = 1;
    private $position = 0;
    private $generatorPosition = 0;
    private $values = [];
    private $keys = [];
    private $options;
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator, $options = self::PRESERVE_KEYS)
    {
        $this->generator = $generator;
        $this->options = $options;
    }

    public function next()
    {
        $this->position++;
    }

    public function valid()
    {
        return ($this->position < $this->generatorPosition) || $this->generator->valid();
    }

    public function current()
    {
        $this->preLoad($this->position);
        if (array_key_exists($this->position, $this->values)) {
            return $this->values[$this->position];
        }
        return false;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function key()
    {
        if ($this->options & self::PRESERVE_KEYS) {
            $this->preLoad($this->position);
            if (array_key_exists($this->position, $this->keys)) {
                return $this->keys[$this->position];
            }
            return false;
        } else {
            return $this->position;
        }
    }

    protected function preLoad($targetPosition)
    {
        if ($targetPosition > $this->generatorPosition) {
            while ($this->generatorPosition <= $targetPosition) {
                if (!$this->generator->valid()) {
                    return;
                }
                $this->values[$this->generatorPosition] = $this->generator->current();
                if ($this->options & self::PRESERVE_KEYS) {
                    $this->keys[$this->generatorPosition] = $this->generator->key();
                }
                $this->generatorPosition++;
                $this->generator->next();
            }
        }
    }
}