<?php

namespace Nayjest\Collection\Behavior;

use Evenement\EventEmitter;

interface BehaviorInterface
{
    public function applyTo(EventEmitter $e);
}