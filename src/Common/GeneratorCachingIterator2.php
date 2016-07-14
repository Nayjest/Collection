<?php

namespace Nayjest\Collection\Common;

use Generator;
use Iterator;

class GeneratorCachingIterator2 implements Iterator
{
    /**
     * @var Generator
     */
    private $generator;
    private $clone;
    private $data = [];
    private $lastKey;
    private $state = 0;
    private $initialGenerator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function next()
    {
        $this->generator->next();
        if ($this->generator->valid()) {
            $lastKey = $this->generator->key();
            $this->data[$lastKey] = $this->generator->current();
        }
    }

    public function valid()
    {
        return $this->generator->valid();
    }

    public function current()
    {
        return $this->data[$this->lastKey];
    }

    public function rewind()
    {
        $fn = function(Generator $generator) {
            foreach($this->data as $key => $value) {
                yield $key => $value;
            }
            while ($generator->valid()) {
                yield $generator->key() => $generator->current();
                $generator->next();
            }
        };
        $this->generator = $fn($this->generator);
    }

    public function key()
    {
        return $this->lastKey;
    }

}