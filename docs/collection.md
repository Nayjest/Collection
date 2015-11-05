`Nayjest\Collection\Collection` Class Reference
----
Collection functionality is splitted to read/write interfaces & traits.

### Methods for modifying collection

#### Sources
* Interface &mdash; [CollectionWriteInterface](https://github.com/Nayjest/Collection/blob/master/src/CollectionWriteInterface.php)
* Implementation &mdash; [CollectionWriteTrait](https://github.com/Nayjest/Collection/blob/master/src/CollectionWriteTrait.php)

All methods for modifying collection returns $this (collection instance) for [method chaining](https://en.wikipedia.org/wiki/Method_chaining) support.

#### `$collection->add(mixed $item, bool $prepend = false)`

Adds item to collection.


#### `$collection->remove(mixed $item)`

Removes items equals to specified value from collection.


#### `$collection->replace(mixed $oldItem, mixed $newItem, bool $forceAdd = true)`

Replaces items equal to $oldItem to $newItem.


If $forceAdd is true, $newItem will be added to collection even if there is no $oldItem.


#### `$collection->clear()`

Removes all items from collection.

#### `$collection->addMany(array|Traversable $items, $prepend = false)`

Adds multiple items to collection.

#### `$collection->set(array|Traversable $items)`

Removes old and sets new collection items.


### Methods for reading collection data

#### Sources
* Interface &mdash; [CollectionReadInterface](https://github.com/Nayjest/Collection/blob/master/src/CollectionReadInterface.php)
* Implementation &mdash; [CollectionReadTrait](https://github.com/Nayjest/Collection/blob/master/src/CollectionReadTrait.php)

#### `$collection->toArray(): array`

Returns collection items in array.

#### `$collection->isEmpty(): bool`

Returns true if collection is empty.


#### `$collection->first(): mixed`

Returns first item of the collection or null if collection is empty.


#### `$collection->contains(mixed $item) : bool`

Checks that collections contains target item.


#### `$collection->filter(callable $callback, array $optionalArguments = null): CollectionInterface`

Iterates over each value in the collection passing them to the callback function.
If the callback function returns true, the current value from collection is returned into the result collection.

**Arguments**

* callable   $callback &mdash; the callback function to use
* array|null $optionalArguments [optional] &mdash; additional arguments passed to callback


#### `$collection->find(callable $callback, array $optionalArguments = null): mixed|false`

Iterates over collection items passing them to the callback function. When callback function returns true, method returns collection item passed to callback.

If there is no items satisfying $condition, method returns (bool)false.

**Arguments**

* callable   $callback &mdash; the callback function to use
* array|null $optionalArguments [optional] &mdash; additional arguments passed to callback


#### `$collection->map(callable $callback, array $optionalArguments = null): CollectionInterface`

**Arguments**

* callable   $callback &mdash; the callback function to use
* array|null $optionalArguments [optional] &mdash; additional arguments passed to callback

#### `$collection->random(): mixed`

Returns random collection element or NULL for empty collection.


#### `$collection->isWritable(): bool`

Returns true if collection implements CollectionWriteInterface.



