<?php

namespace Nayjest\Collection\Exception;

use RuntimeException;

class ReadonlyException extends RuntimeException implements CollectionException
{
}