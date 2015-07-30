<?php
namespace Nayjest\Collection\Exceptions;

use InvalidArgumentException;

class InvalidItemException extends InvalidArgumentException
{
    public function __construct($item, array $expectedTypes)
    {
        $actualClass = get_class($item);
        parent::__construct(
            "Trying to add $actualClass"
            . 'to collection that supports only following types:'
            . implode(', ', $expectedTypes)
            . '.'
        );
    }
}