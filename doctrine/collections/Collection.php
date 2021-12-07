<?php

/*
Copyright (c) 2006-2013 Doctrine Project

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

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

namespace Doctrine\Common\Collections;

use ArrayAccess;
use Closure;
use Countable;
use IteratorAggregate;

/**
 * The missing (SPL) Collection/Array/OrderedMap interface.
 *
 * A Collection resembles the nature of a regular PHP array. That is,
 * it is essentially an <b>ordered map</b> that can also be used
 * like a list.
 *
 * A Collection has an internal iterator just like a PHP array. In addition,
 * a Collection can be iterated with external iterators, which is preferable.
 * To use an external iterator simply use the foreach language construct to
 * iterate over the collection (which calls {@link getIterator()} internally) or
 * explicitly retrieve an iterator though {@link getIterator()} which can then be
 * used to iterate over the collection.
 * You can not rely on the internal iterator of the collection being at a certain
 * position unless you explicitly positioned it before. Prefer iteration with
 * external iterators.
 *
 * @template TKey of array-key
 * @template T
 * @template-extends IteratorAggregate<TKey, T>
 * @template-extends ArrayAccess<TKey, T>
 */
interface Collection extends Countable, IteratorAggregate, ArrayAccess
{
	/**
	 * Adds an element at the end of the collection.
	 *
	 * @param T $element The element to add.
	 *
	 * @return true Always TRUE.
	 */
	public function add($element);

	/**
	 * Clears the collection, removing all elements.
	 *
	 * @return void
	 */
	public function clear();

	/**
	 * Checks whether an element is contained in the collection.
	 * This is an O(n) operation, where n is the size of the collection.
	 *
	 * @param T $element The element to search for.
	 *
	 * @return bool TRUE if the collection contains the element, FALSE otherwise.
	 */
	public function contains($element);

	/**
	 * Checks whether the collection is empty (contains no elements).
	 *
	 * @return bool TRUE if the collection is empty, FALSE otherwise.
	 * @psalm-assert-if-false T $this->first()
	 * @psalm-assert-if-true false $this->first()
	 * @psalm-assert-if-false T $this->last()
	 * @psalm-assert-if-true false $this->last()
	 */
	public function isEmpty();

	/**
	 * Removes the element at the specified index from the collection.
	 *
	 * @param TKey $key The key/index of the element to remove.
	 *
	 * @return T|null The removed element or NULL, if the collection did not contain the element.
	 */
	public function remove($key);

	/**
	 * Removes the specified element from the collection, if it is found.
	 *
	 * @param T $element The element to remove.
	 *
	 * @return bool TRUE if this collection contained the specified element, FALSE otherwise.
	 */
	public function removeElement($element);

	/**
	 * Checks whether the collection contains an element with the specified key/index.
	 *
	 * @param TKey $key The key/index to check for.
	 *
	 * @return bool TRUE if the collection contains an element with the specified key/index,
	 *              FALSE otherwise.
	 */
	public function containsKey($key);

	/**
	 * Gets the element at the specified key/index.
	 *
	 * @param TKey $key The key/index of the element to retrieve.
	 *
	 * @return T|null
	 */
	public function get($key);

	/**
	 * Gets all keys/indices of the collection.
	 *
	 * @return TKey[] The keys/indices of the collection, in the order of the corresponding
	 *               elements in the collection.
	 */
	public function getKeys();

	/**
	 * Gets all values of the collection.
	 *
	 * @return list<T> The values of all elements in the collection, in the
	 *                 order they appear in the collection.
	 */
	public function getValues();

	/**
	 * Sets an element in the collection at the specified key/index.
	 *
	 * @param TKey $key   The key/index of the element to set.
	 * @param T    $value The element to set.
	 *
	 * @return void
	 */
	public function set($key, $value);

	/**
	 * Gets a native PHP array representation of the collection.
	 *
	 * @return array<TKey,T>
	 */
	public function toArray();

	/**
	 * Sets the internal iterator to the first element in the collection and returns this element.
	 *
	 * @return T|false
	 */
	public function first();

	/**
	 * Sets the internal iterator to the last element in the collection and returns this element.
	 *
	 * @return T|false
	 */
	public function last();

	/**
	 * Gets the key/index of the element at the current iterator position.
	 *
	 * @return TKey|null
	 */
	public function key();

	/**
	 * Gets the element of the collection at the current iterator position.
	 *
	 * @return T|false
	 */
	public function current();

	/**
	 * Moves the internal iterator position to the next element and returns this element.
	 *
	 * @return T|false
	 */
	public function next();

	/**
	 * Tests for the existence of an element that satisfies the given predicate.
	 *
	 * @param Closure $p The predicate.
	 * @psalm-param Closure(TKey=, T=):bool $p
	 *
	 * @return bool TRUE if the predicate is TRUE for at least one element, FALSE otherwise.
	 */
	public function exists(Closure $p);

	/**
	 * Returns all the elements of this collection that satisfy the predicate p.
	 * The order of the elements is preserved.
	 *
	 * @param Closure $p The predicate used for filtering.
	 * @psalm-param Closure(T=):bool $p
	 *
	 * @return Collection<TKey, T> A collection with the results of the filter operation.
	 */
	public function filter(Closure $p);

	/**
	 * Tests whether the given predicate p holds for all elements of this collection.
	 *
	 * @param Closure $p The predicate.
	 * @psalm-param Closure(TKey=, T=):bool $p
	 *
	 * @return bool TRUE, if the predicate yields TRUE for all elements, FALSE otherwise.
	 */
	public function forAll(Closure $p);

	/**
	 * Applies the given function to each element in the collection and returns
	 * a new collection with the elements returned by the function.
	 *
	 * @psalm-param Closure(T=):U $func
	 *
	 * @return Collection<TKey, U>
	 *
	 * @psalm-template U
	 */
	public function map(Closure $func);

	/**
	 * Partitions this collection in two collections according to a predicate.
	 * Keys are preserved in the resulting collections.
	 *
	 * @param Closure $p The predicate on which to partition.
	 * @psalm-param Closure(TKey=, T=):bool $p
	 *
	 * @return Collection<TKey, T>[] An array with two elements. The first element contains the collection
	 *                      of elements where the predicate returned TRUE, the second element
	 *                      contains the collection of elements where the predicate returned FALSE.
	 * @psalm-return array{0: Collection<TKey, T>, 1: Collection<TKey, T>}
	 */
	public function partition(Closure $p);

	/**
	 * Gets the index/key of a given element. The comparison of two elements is strict,
	 * that means not only the value but also the type must match.
	 * For objects this means reference equality.
	 *
	 * @param T $element The element to search for.
	 *
	 * @return TKey|false The key/index of the element or FALSE if the element was not found.
	 */
	public function indexOf($element);

	/**
	 * Extracts a slice of $length elements starting at position $offset from the Collection.
	 *
	 * If $length is null it returns all elements from $offset to the end of the Collection.
	 * Keys have to be preserved by this method. Calling this method will only return the
	 * selected slice and NOT change the elements contained in the collection slice is called on.
	 *
	 * @param int      $offset The offset to start from.
	 * @param int|null $length The maximum number of elements to return, or null for no limit.
	 *
	 * @return array<TKey,T>
	 */
	public function slice($offset, $length = null);
}