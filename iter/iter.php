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
 * @psalm-pure
 *
 * @template T of int|float
 *
 * @param T $start
 * @param T $end
 * @param T|null $step
 *
 * @return \Iterator<T>
 */
function range($start, $end, $step = null): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TBefore
 * @template TAfter
 * @template TKey
 *
 * @param callable(TBefore):TAfter $function
 * @param iterable<TKey, TBefore> $iterable
 *
 * @return \Iterator<TKey, TAfter>
 */
function map(callable $function, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TBefore
 * @template TAfter
 * @template TValue
 *
 * @param callable(TBefore):TAfter $function
 * @param iterable<TBefore, TValue> $iterable
 *
 * @return \Iterator<TAfter, TValue>
 */
function mapKeys(callable $function, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TVBefore
 * @template TKAfter
 * @template TVAfter
 *
 * @param callable(TVBefore):iterable<TKAfter, TVAfter> $function
 * @param iterable<TVBefore> $iterable
 *
 * @return \Iterator<TKAfter, TVAfter>
 */
function flatMap(callable $function, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TValue
 * @template TKBefore
 * @template TKAfter
 *
 * @param callable(TValue):TKAfter $function
 * @param iterable<TKBefore, TValue> $iterable
 *
 * @return \Iterator<TKAfter, TValue>
 */
function reindex(callable $function, iterable $iterable): \Iterator {}

/**
 * @template T
 *
 * @param callable(T):void $function
 * @param iterable<T> $iterable
 *
 * @return void
 */
function apply(callable $function, iterable $iterable): void {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param callable(TValue):bool $predicate
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<TKey, TValue>
 */
function filter(callable $predicate, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<array{0:TKey, 1:TValue}>
 */
function enumerate(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<array{0:TKey, 1:TValue}>
 */
function toPairs(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<array{0:TKey, 1:TValue}> $iterable
 *
 * @return \Iterator<TKey, TValue>
 */
function fromPairs(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 * @template TAcc
 *
 * @param callable(TAcc, TValue, TKey=):TAcc $function
 * @param iterable<TKey, TValue> $iterable
 * @param TAcc $startValue
 *
 * @return TAcc
 */
function reduce(callable $function, iterable $iterable, $startValue = null) {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 * @template TAcc
 *
 * @param callable(TAcc, TValue, TKey=):TAcc $function
 * @param iterable<TKey, TValue> $iterable
 * @param TAcc $startValue
 *
 * @return \Iterator<TAcc>
 */
function reductions(callable $function, iterable $iterable, $startValue = null): \Iterator {}

/**
 * @psalm-pure
 *
 * FIXME: this is very simplified approach as it does not consider different types for
 * different iterables. However, it seems, this is not fixable using psalm.
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> ...$iterables
 * @return \Iterator<array<TKey, TValue>>
 */
function zip(iterable ...$iterables): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<mixed, TKey> $keys
 * @param iterable<mixed, TValue> $values
 *
 * @return \Iterator<TKey, TValue>
 */
function zipKeyValue(iterable $keys, iterable $values): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> ...$iterables
 * @return \Iterator<TKey, TValue>
 */
function chain(iterable ...$iterables): \Iterator {}

/**
 * @psalm-pure
 *
 * FIXME: again, this is very simplified approach as it does not consider different types for
 * different iterables. However, it seems, this is not fixable using psalm.
 *
 * @template TValue
 *
 * @param iterable<mixed, TValue> ...$iterables
 * @return \Iterator<list<TValue>>
 */
function product(iterable ...$iterables): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 * @param int $start
 * @param int $length
 *
 * @return \Iterator<TKey, TValue>
 */
function slice(iterable $iterable, int $start, $length = INF): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param int $num
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<TKey, TValue>
 */
function take(int $num, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param int $num
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<TKey, TValue>
 */
function drop(int $num, iterable $iterable): \Iterator {
	return slice($iterable, $num);
}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param T $value
 * @param int $num
 *
 * @throws \InvalidArgumentException if num is negative
 *
 * @return \Iterator<T>
 */
function repeat($value, $num = INF): \Iterator {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<T, mixed> $iterable
 *
 * @return \Iterator<T>
 */
function keys(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<mixed, T> $iterable
 *
 * @return \Iterator<T>
 */
function values($iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param callable(T):bool $predicate
 * @param iterable<T> $iterable
 *
 * @return bool
 */
function any(callable $predicate, iterable $iterable): bool {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param callable(T):bool $predicate
 * @param iterable<T> $iterable
 *
 * @return bool
 */
function all(callable $predicate, iterable $iterable): bool {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param callable(T):bool $predicate
 * @param iterable<T> $iterable
 *
 * @return null|T
 */
function search(callable $predicate, iterable $iterable) {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param callable(T):bool $predicate
 * @param iterable<T> $iterable
 *
 * @return \Iterator<T>
 */
function takeWhile(callable $predicate, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param callable(T):bool $predicate
 * @param iterable<T> $iterable
 *
 * @return \Iterator<T>
 */
function dropWhile(callable $predicate, iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * FIXME: probably not solvable without recursive types like in TypeScript.
 * Types are only describen for $levels = 1.
 *
 * @template T
 *
 * @param iterable<iterable<T>> $iterable
 * @param int $levels
 * @return \Iterator<T>
 */
function flatten(iterable $iterable, $levels = INF): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<TValue, TKey>
 */
function flip(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 * @param int $size
 * @param bool $preserveKeys
 *
 * @return \Iterator<list<TValue>|array<TKey, TValue>>
 */
function chunk(iterable $iterable, int $size, bool $preserveKeys = false): \Iterator {}

/**
 * @psalm-pure
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 * @param int $size
 *
 * @return \Iterator<array<TKey, TValue>>
 */
function chunkWithKeys(iterable $iterable, int $size): \Iterator {}

/**
 * @psalm-pure
 *
 * FIXME: how to specify objects implementing __toString() ?
 *
 * @param string $separator
 * @param iterable<string|object> $iterable
 *
 * @return string
 */
function join(string $separator, iterable $iterable): string {}

/**
 * @psalm-pure
 *
 * @param iterable|\Countable $iterable
 * @return int
 */
function count($iterable): int {}

/**
 * @psalm-pure
 *
 * @param iterable|\Countable $iterable
 * @return bool
 */
function isEmpty($iterable): bool {}

/**
 * @psalm-pure
 *
 * @template TKey
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return \Iterator<TKey, TValue>
 */
function toIter(iterable $iterable): \Iterator {}

/**
 * @psalm-pure
 *
 * @template T
 *
 * @param iterable<T> $iterable
 *
 * @return list<T>
 */
function toArray(iterable $iterable): array {}

/**
 * @psalm-pure
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return array<TKey, TValue>
 */
function toArrayWithKeys(iterable $iterable): array {}

/**
 * @psalm-pure
 *
 * @param $value
 *
 * @psalm-assert-if-true iterable $value
 */
function isIterable($value): bool {}

