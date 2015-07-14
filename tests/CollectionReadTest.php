<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.07.2015
 * Time: 17:39
 */

namespace Nayjest\Collection\Test;


use Nayjest\Collection\Collection;

class CollectionReadTest extends AbstractCollectionReadTest
{
    protected function makeCollection($data)
    {
        return new Collection($data);
    }
}