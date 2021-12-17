<?php
/**
MIT License

Copyright (c) 2020 Alexey Shokov

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

declare(strict_types=1);

namespace iter;

/**
 * Creates an iterable containing all numbers between the start and end value
 * (inclusive) with a certain step.
 *
 * Examples:
 *
 *     iter\range(0, 5)
 *     => iter(0, 1, 2, 3, 4, 5)
 *     iter\range(5, 0)
 *     => iter(5, 4, 3, 2, 1, 0)
 *     iter\range(0.0, 3.0, 0.5)
 *     => iter(0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.0)
 *     iter\range(3.0, 0.0, -0.5)
 *     => iter(3.0, 2.5, 2.0, 1.5, 1.0, 0.5, 0.0)
 *
 * @psalm-pure
 *
 * @template T of int|float
 *
 * @param T $start First number (inclusive)
 * @param T $end Last number (inclusive, but doesn't have to be part of
 *                         resulting range if $step steps over it)
 * @param T|null $step Step between numbers (defaults to 1 if $start smaller
 *                         $end and to -1 if $start greater $end)
 *
 * @throws \InvalidArgumentException if step is not valid
 *
 * @return \Iterator<T>
 */
function range($start, $end, $step = null): \Iterator {}

/**
 * Applies a mapping function to all values of an iterator.
 *
 * The function is passed the current iterator value and should return a
 * modified iterator value. The key is left as-is and not passed to the mapping
 * function.
 *
 * Examples:
 *
 *     iter\map(iter\fn\operator('*', 2), [1, 2, 3, 4, 5]);
 *     => iter(2, 4, 6, 8, 10)
 *
 *     $column = map(fn\index('name'), $iter);
 *
 * @psalm-pure
 *
 * @template TBefore
 * @template TAfter
 * @template TKey
 *
 * @param callable(TBefore):TAfter $function Mapping function: mixed function(mixed $value)
 * @param iterable<TKey, TBefore> $iterable Iterable to be mapped over
 *
 * @return \Iterator<TKey, TAfter>
 */
function map(callable $function, iterable $iterable): \Iterator {}

/**
 * Applies a mapping function to all keys of an iterator.
 *
 * The function is passed the current iterator key and should return a
 * modified iterator key. The value is left as-is and not passed to the mapping
 * function.
 *
 * Examples:
 *
 *     iter\mapKeys('strtolower', ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4]);
 *     => iter('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4)
 *
 * @psalm-pure
 *
 * @template TBefore
 * @template TAfter
 * @template TValue
 *
 * @param callable(TBefore):TAfter $function Mapping function: mixed function(mixed $key)
 * @param iterable<TBefore, TValue> $iterable Iterable those keys are to be mapped over
 *
 * @return \Iterator<TAfter, TValue>
 */
function mapKeys(callable $function, iterable $iterable): \Iterator {}

/**
 * Applies a function to each value in an iterator and flattens the result.
 *
 * The function is passed the current iterator value and should return an
 * iterator of new values. The result will be a concatenation of the iterators
 * returned by the mapping function.
 *
 * Examples:
 *
 *     iter\flatMap(function($v) { return [-$v, $v]; }, [1, 2, 3, 4, 5]);
 *     => iter(-1, 1, -2, 2, -3, 3, -4, 4, -5, 5)
 *
 * @psalm-pure
 *
 * @template TVBefore
 * @template TKAfter
 * @template TVAfter
 *
 * @param callable(TVBefore):iterable<TKAfter, TVAfter> $function Mapping function: iterable function(mixed $value)
 * @param iterable<TVBefore> $iterable Iterable to be mapped over
 *
 * @return \Iterator<TKAfter, TVAfter>
 */
function flatMap(callable $function, iterable $iterable): \Iterator {}

/**
 * Reindexes an array by applying a function to all values of an iterator and
 * using the returned value as the new key/index.
 *
 * The function is passed the current iterator value and should return a new
 * key for that element. The value is left as-is. The original key is not passed
 * to the mapping function.
 *
 * Examples:
 *
 *     $users = [
 *         ['id' => 42, 'name' => 'foo'],
 *         ['id' => 24, 'name' => 'bar']
 *     ];
 *     iter\reindex(iter\fn\index('id'), $users)
 *     => iter(
 *         42 => ['id' => 42, 'name' => 'foo'],
 *         24 => ['id' => 24, 'name' => 'bar']
 *     )
 *
 * @psalm-pure
 *
 * @template TValue
 * @template TKBefore
 * @template TKAfter
 *
 * @param callable(TValue):TKAfter $function Mapping function mixed function(mixed $value)
 * @param iterable<TKBefore, TValue> $iterable Iterable to reindex
 *
 * @return \Iterator<TKAfter, TValue>
 */
function reindex(callable $function, iterable $iterable): \Iterator {}

/**
 * Applies a function to all values of an iterable.
 *
 * The function is passed the current iterator value. The reason why apply
 * exists additionally to map is that map is lazy, whereas apply is not (i.e.
 * you do not need to consume a resulting iterator for the function calls to
 * actually happen.)
 *
 * Examples:
 *
 *     iter\apply(iter\fn\method('rewind'), $iterators);
 *
 * @template T
 *
 * @param callable(T):void $function Apply function: void function(mixed $value)
 * @param iterable<T> $iterable Iterator to apply on
 *
 * @return void
 */
function apply(callable $function, iterable $iterable): void {}

/**
 * Filters an iterable using a predicate.
 *
 * The predicate is passed the iterator value, which is only retained if the
 * predicate returns a truthy value. The key is not passed to the predicate and
 * left as-is.
 *
 * Examples:
 *
 *     iter\filter(iter\fn\operator('<', 0), [0, -1, -10, 7, 20, -5, 7]);
 *     => iter(-1, -10, -5)
 *
 *     iter\filter(iter\fn\operator('instanceof', 'SomeClass'), $objects);
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param callable(TValue):bool $predicate Predicate: bool function(mixed $value)
 * @param iterable<TKey, TValue> $iterable Iterable to filter
 *
 * @return \Iterator<TKey, TValue>
 */
function filter(callable $predicate, iterable $iterable): \Iterator {}

/**
 * Enumerates pairs of [key, value] of an iterable.
 *
 * Examples:
 *
 *      iter\enumerate(['a', 'b']);
 *      => iter([0, 'a'], [1, 'b'])
 *
 *      $values = ['a', 'b', 'c', 'd'];
 *      $filter = function($t) { return $t[0] % 2 == 0; };
 *      iter\map(iter\fn\index(1), iter\filter($filter, iter\enumerate($values)));
 *      => iter('a', 'c')
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable Iterable to enumerate
 *
 * @return \Iterator<array{0:TKey, 1:TValue}>
 */
function enumerate(iterable $iterable): \Iterator {}

///**
// * @psalm-pure
// *
// * @template TKey
// * @template TValue
// *
// * @param iterable<TKey, TValue> $iterable
// *
// * @return \Iterator<array{0:TKey, 1:TValue}>
// */
//function toPairs(iterable $iterable): \Iterator {}

///**
// * @psalm-pure
// *
// * @template TKey
// * @template TValue
// *
// * @param iterable<array{0:TKey, 1:TValue}> $iterable
// *
// * @return \Iterator<TKey, TValue>
// */
//function fromPairs(iterable $iterable): \Iterator {}

/**
 * Reduce iterable using a function.
 *
 * The reduction function is passed an accumulator value and the current
 * iterator value and returns a new accumulator. The accumulator is initialized
 * to $startValue.
 *
 * Examples:
 *
 *      reduce(fn\operator('+'), range(1, 5), 0)
 *      => 15
 *      reduce(fn\operator('*'), range(1, 5), 1)
 *      => 120
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 * @template TAcc
 *
 * @param callable $function Reduction function:
 *                           mixed function(mixed $acc, mixed $value, mixed $key)
 * @psalm-param callable(TAcc, TValue, TKey=):TAcc $function
 * @param iterable<TKey, TValue> $iterable Iterable to reduce
 * @param TAcc $startValue Start value for accumulator.
 *                          Usually identity value of $function.
 *
 * @return TAcc Result of the reduction
 */
function reduce(callable $function, iterable $iterable, $startValue = null) {}

/**
 * Intermediate values of reducing iterable using a function.
 *
 * The reduction function is passed an accumulator value and the current
 * iterator value and returns a new accumulator. The accumulator is initialized
 * to $startValue.
 *
 * Reductions yield each accumulator along the way.
 *
 * Examples:
 *
 *      reductions(fn\operator('+'), range(1, 5), 0)
 *      => iter(1, 3, 6, 10, 15)
 *      reductions(fn\operator('*'), range(1, 5), 1)
 *      => iter(1, 2, 6, 24, 120)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 * @template TAcc
 *
 * @param callable $function Reduction function:
 *                           mixed function(mixed $acc, mixed $value, mixed $key)
 * @psalm-param callable(TAcc, TValue, TKey=):TAcc $function
 * @param iterable<TKey, TValue> $iterable Iterable to reduce
 * @param TAcc $startValue Start value for accumulator.
 *                          Usually identity value of $function.
 *
 * @return \Iterator<TAcc> Intermediate results of the reduction
 */
function reductions(callable $function, iterable $iterable, $startValue = null): \Iterator {}

/**
 * Zips the iterables that were passed as arguments.
 *
 * Afterwards keys and values will be arrays containing the keys/values of
 * the individual iterables. This function stops as soon as the first iterable
 * becomes invalid.
 *
 * Examples:
 *
 *     iter\zip([1, 2, 3], [4, 5, 6], [7, 8, 9])
 *     => iter([1, 4, 7], [2, 5, 8], [3, 6, 9])
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> ...$iterables Iterables to zip
 * @return \Iterator<array<TKey, TValue>>
 */
function zip(iterable ...$iterables): \Iterator {}

/**
 * Combines an iterable for keys and another for values into one iterator.
 *
 * Examples:
 *
 *     iter\zipKeyValue(['a', 'b', 'c'], [1, 2, 3])
 *     => iter('a' => 1, 'b' => 2, 'c' => 3)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<mixed, TKey> $keys Iterable of keys
 * @param iterable<mixed, TValue> $values Iterable of values
 *
 * @return \Iterator<TKey, TValue>
 */
function zipKeyValue(iterable $keys, iterable $values): \Iterator {}

/**
 * Chains the iterables that were passed as arguments.
 *
 * The resulting iterator will contain the values of the first iterable, then
 * the second, and so on.
 *
 * Examples:
 *
 *     iter\chain(iter\range(0, 5), iter\range(6, 10), iter\range(11, 15))
 *     => iter(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> ...$iterables Iterables to chain
 * @return \Iterator<TKey, TValue>
 */
function chain(iterable ...$iterables): \Iterator {}

/**
 * Returns the cartesian product of iterables that were passed as arguments.
 *
 * The resulting iterator will contain all the possible tuples of keys and
 * values.
 *
 * Please note that the iterables after the first must be rewindable.
 *
 * Examples:
 *
 *     iter\product(iter\range(1, 2), iter\rewindable\range(3, 4))
 *     => iter([1, 3], [1, 4], [2, 3], [2, 4])
 *
 * @psalm-pure
 *
 * @template TValue
 *
 * @param iterable<mixed, TValue> ...$iterables Iterables to combine
 * @return \Iterator<list<TValue>>
 */
function product(iterable ...$iterables): \Iterator {}

/**
 * Takes a slice from an iterable.
 *
 * Examples:
 *
 *      iter\slice([-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5], 5)
 *      => iter(0, 1, 2, 3, 4, 5)
 *      iter\slice([-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5], 5, 3)
 *      => iter(0, 1, 2, 3)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable Iterable to take the slice from
 * @param int $start Start offset
 * @param int $length Length (if not specified all remaining values from the
 *                    iterable are used)
 *
 * @return \Iterator<TKey, TValue>
 */
function slice(iterable $iterable, int $start, $length = INF): \Iterator {}

/**
 * Takes the first n items from an iterable.
 *
 * Examples:
 *
 *      iter\take(3, [1, 2, 3, 4, 5])
 *      => iter(1, 2, 3)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param int $num Number of elements to take from the start
 * @param iterable<TKey, TValue> $iterable Iterable to take the elements from
 *
 * @return \Iterator<TKey, TValue>
 */
function take(int $num, iterable $iterable): \Iterator {}

/**
 * Drops the first n items from an iterable.
 *
 * Examples:
 *
 *      iter\drop(3, [1, 2, 3, 4, 5])
 *      => iter(4, 5)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param int $num Number of elements to drop from the start
 * @param iterable<TKey, TValue> $iterable Iterable to drop the elements from
 *
 * @return \Iterator<TKey, TValue>
 */
function drop(int $num, iterable $iterable): \Iterator {
	return slice($iterable, $num);
}

/**
 * Repeat an element a given number of times. By default the element is repeated
 * indefinitely.
 *
 * Examples:
 *
 *     iter\repeat(42, 5)
 *     => iter(42, 42, 42, 42, 42)
 *     iter\repeat(1)
 *     => iter(1, 1, 1, 1, 1, 1, 1, 1, 1, ...)
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param T $value Value to repeat
 * @param int $num Number of repetitions (defaults to INF)
 *
 * @throws \InvalidArgumentException if num is negative
 *
 * @return \Iterator<T>
 */
function repeat($value, $num = INF): \Iterator {}

/**
 * Returns the keys of an iterable.
 *
 * Examples:
 *
 *      iter\keys(['a' => 0, 'b' => 1, 'c' => 2])
 *      => iter('a', 'b', 'c')
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<T, mixed> $iterable Iterable to get keys from
 *
 * @return \Iterator<T>
 */
function keys(iterable $iterable): \Iterator {}

/**
 * Returns the values of an iterable, making the keys continuously indexed.
 *
 * Examples:
 *
 *      iter\values([17 => 1, 42 => 2, -2 => 100])
 *      => iter(0 => 1, 1 => 42, 2 => 100)
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<mixed, T> $iterable Iterable to get values from
 *
 * @return \Iterator<T>
 */
function values($iterable): \Iterator {}

/**
 * Returns true if there is a value in the iterable that satisfies the
 * predicate.
 *
 * This function is short-circuiting, i.e. if the predicate matches for any one
 * element the remaining elements will not be considered anymore.
 *
 * Examples:
 *
 *      iter\all(fn\operator('>', 0), range(1, 10))
 *      => true
 *      iter\all(fn\operator('>', 0), range(-5, 5))
 *      => false
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param callable $predicate Predicate: bool function(mixed $value)
 * @psalm-param callable(T):bool $predicate
 * @param iterable<T> $iterable Iterable to check against the predicate
 *
 * @return bool Whether the predicate matches any value
 */
function any(callable $predicate, iterable $iterable): bool {}

/**
 * Returns true if all values in the iterable satisfy the predicate.
 *
 * This function is short-circuiting, i.e. if the predicate fails for one
 * element the remaining elements will not be considered anymore.
 *
 * Examples:
 *
 *      iter\all(fn\operator('>', 0), range(1, 10))
 *      => true
 *      iter\all(fn\operator('>', 0), range(-5, 5))
 *      => false
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param callable $predicate Predicate: bool function(mixed $value)
 * @psalm-param callable(T):bool $predicate
 * @param iterable<T> $iterable Iterable to check against the predicate
 *
 * @return bool Whether the predicate holds for all values
 */
function all(callable $predicate, iterable $iterable): bool {}

/**
 * Searches an iterable until a predicate returns true, then returns
 * the value of the matching element.
 *
 * Examples:
 *
 *      iter\search(iter\fn\operator('===', 'baz'), ['foo', 'bar', 'baz'])
 *      => 'baz'
 *
 *      iter\search(iter\fn\operator('===', 'qux'), ['foo', 'bar', 'baz'])
 *      => null
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param callable $predicate Predicate: bool function(mixed $value)
 * @psalm-param callable(T):bool $predicate
 * @param iterable<T> $iterable The iterable to search
 *
 * @return null|T
 */
function search(callable $predicate, iterable $iterable) {}

/**
 * Takes items from an iterable until the predicate fails for the first time.
 *
 * This means that all elements before (and excluding) the first element on
 * which the predicate fails will be returned.
 *
 * Examples:
 *
 *      iter\takeWhile(fn\operator('>', 0), [3, 1, 4, -1, 5])
 *      => iter(3, 1, 4)
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param callable $predicate Predicate: bool function(mixed $value)
 * @psalm-param callable(T):bool $predicate
 * @param iterable<T> $iterable Iterable to take values from
 *
 * @return \Iterator<T>
 */
function takeWhile(callable $predicate, iterable $iterable): \Iterator {}

/**
 * Drops items from an iterable until the predicate fails for the first time.
 *
 * This means that all elements after (and including) the first element on
 * which the predicate fails will be returned.
 *
 * Examples:
 *
 *      iter\dropWhile(fn\operator('>', 0), [3, 1, 4, -1, 5])
 *      => iter(-1, 5)
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param callable $predicate Predicate: bool function(mixed $value)
 * @psalm-param callable(T):bool $predicate
 * @param iterable<T> $iterable Iterable to drop values from
 *
 * @return \Iterator<T>
 */
function dropWhile(callable $predicate, iterable $iterable): \Iterator {}

/**
 * Takes an iterable containing any amount of nested iterables and returns
 * a flat iterable with just the values.
 *
 * The $level argument allows to limit flattening to a certain number of levels.
 *
 * Examples:
 *
 *      iter\flatten([1, [2, [3, 4]], [5]])
 *      => iter(1, 2, 3, 4, 5)
 *      iter\flatten([1, [2, [3, 4]], [5]], 1)
 *      => iter(1, 2, [3, 4], 5)
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<iterable<T>> $iterable Iterable to flatten
 * @param int $levels Number of levels to flatten
 * @return \Iterator<T>
 */
function flatten(iterable $iterable, $levels = INF): \Iterator {}

/**
 * Flips the keys and values of an iterable.
 *
 * Examples:
 *
 *      iter\flip(['a' => 1, 'b' => 2, 'c' => 3])
 *      => iter(1 => 'a', 2 => 'b', 3 => 'c')
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable The iterable to flip
 *
 * @return \Iterator<TValue, TKey>
 */
function flip(iterable $iterable): \Iterator {}

/**
 * Chunks an iterable into arrays of the specified size.
 *
 * Each chunk is an array (non-lazy), but the chunks are yielded lazily.
 *
 * Examples:
 *
 *      iter\chunk([1, 2, 3, 4, 5], 3)
 *      => iter([1, 2, 3], [4, 5])
 *
 * @psalm-pure
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable The iterable to chunk
 * @param int $size The size of each chunk
 * @param bool $preserveKeys Whether to preserve keys from the input iterable
 *
 * @return \Iterator<list<TValue>|array<TKey, TValue>>
 */
function chunk(iterable $iterable, int $size, bool $preserveKeys = false): \Iterator {}

///**
// * @psalm-pure
// *
// * @template TKey of array-key
// * @template TValue
// *
// * @param iterable<TKey, TValue> $iterable
// * @param int $size
// *
// * @return \Iterator<array<TKey, TValue>>
// */
//function chunkWithKeys(iterable $iterable, int $size): \Iterator {}

/**
 * Joins the elements of an iterable with a separator between them.
 *
 * Examples:
 *
 *      iter\join(', ', ['a', 'b', 'c'])
 *      => "a, b, c"
 *
 * @psalm-pure
 *
 * @param string $separator Separator to use between elements
 * @param iterable<string|object> $iterable The iterable to join
 *
 * @return string
 */
function join(string $separator, iterable $iterable): string {}

/**
 * Returns the number of elements an iterable contains.
 *
 * This function is not recursive, it counts only the number of elements in the
 * iterable itself, not its children.
 *
 * If the iterable implements Countable its count() method will be used.
 *
 * Examples:
 *
 *      iter\count([1, 2, 3])
 *      => 3
 *
 *      iter\count(iter\flatten([1, 2, 3, [4, [[[5, 6], 7]]], 8]))
 *      => 8
 *
 * @psalm-pure
 *
 * @param iterable|\Countable $iterable The iterable to count
 * @return int
 */
function count($iterable): int {}

/**
 * Determines whether iterable is empty.
 *
 * If the iterable implements Countable, its count() method will be used.
 * Calling isEmpty() does not drain iterators, as only the valid() method will
 * be called.
 *
 * @psalm-pure
 *
 * @param iterable|\Countable $iterable
 * @return bool
 */
function isEmpty($iterable): bool {}

/**
 * Converts any iterable into an Iterator.
 *
 * Examples:
 *
 *      iter\toIter([1, 2, 3])
 *      => iter(1, 2, 3)
 *
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable The iterable to turn into an iterator
 *
 * @return \Iterator<TKey, TValue>
 */
function toIter(iterable $iterable): \Iterator {}

/**
 * Converts an iterable into an array, without preserving keys.
 *
 * Not preserving the keys is useful, because iterators do not necessarily have
 * unique keys and/or the key type is not supported by arrays.
 *
 * Examples:
 *
 *      iter\toArray(new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]))
 *      => [1, 2, 3]
 *
 *      iter\toArray(iter\chain(['a' => 1, 'b' => 2], ['a' => 3]))
 *      => [1, 2, 3]
 *
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<T> $iterable The iterable to convert to an array
 *
 * @return list<T>
 */
function toArray(iterable $iterable): array {}

/**
 * Converts an iterable into an array and preserves its keys.
 *
 * If the keys are not unique, newer keys will overwrite older keys. If a key
 * is not a string or an integer, the usual array key casting rules (and
 * associated notices/warnings) apply.
 *
 * Examples:
 *
 *      iter\toArrayWithKeys(new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]))
 *      => ['a' => 1, 'b' => 2, 'c' => 3]
 *
 *      iter\toArrayWithKeys(iter\chain(['a' => 1, 'b' => 2], ['a' => 3]))
 *      => ['a' => 3, 'b' => 2]
 *
 * @psalm-pure
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable The iterable to convert to an array
 *
 * @return array<TKey, TValue>
 */
function toArrayWithKeys(iterable $iterable): array {}

/**
 * Determines whether a value is an iterable.
 *
 * Only arrays and objects implementing Traversable are considered as iterable.
 * In particular objects that don't implement Traversable are not considered as
 * iterable, even though PHP would accept them in a foreach() loop.
 *
 * Examples:
 *
 *     iter\isIterable([1, 2, 3])
 *     => true
 *
 *     iter\isIterable(new ArrayIterator([1, 2, 3]))
 *     => true
 *
 *     iter\isIterable(new stdClass)
 *     => false
 *
 * @psalm-pure
 *
 * @param mixed $value Value to check
 *
 * @return bool Whether the passed value is an iterable
 *
 * @psalm-assert-if-true iterable $value
 */
function isIterable($value): bool {}

