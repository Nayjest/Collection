<?php
namespace Nayjest\Collection\Exceptions;

use InvalidArgumentException;

/**
 * Class for exceptions about invalid type of items used with collection.
 */
class InvalidItemException extends InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $item
     * @param string[] $expectedTypes
     */
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
