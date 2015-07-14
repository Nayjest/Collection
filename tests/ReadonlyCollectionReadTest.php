<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.07.2015
 * Time: 17:39
 */

namespace Nayjest\Collection\Test;


use Nayjest\Collection\Collection;
use Nayjest\Collection\Decorator\ReadonlyCollection;

class ReadonlyCollectionReadTest extends AbstractCollectionReadTest
{
    protected function makeCollection($data)
    {
        return new ReadonlyCollection(new Collection($data));
    }
}