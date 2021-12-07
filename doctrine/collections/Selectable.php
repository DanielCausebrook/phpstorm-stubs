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

/**
 * Interface for collections that allow efficient filtering with an expression API.
 *
 * Goal of this interface is a backend independent method to fetch elements
 * from a collections. {@link Expression} is crafted in a way that you can
 * implement queries from both in-memory and database-backed collections.
 *
 * For database backed collections this allows very efficient access by
 * utilizing the query APIs, for example SQL in the ORM. Applications using
 * this API can implement efficient database access without having to ask the
 * EntityManager or Repositories.
 *
 * @psalm-template TKey as array-key
 * @psalm-template T
 */
interface Selectable
{
	/**
	 * Selects all elements from a selectable that match the expression and
	 * returns a new collection containing these elements.
	 *
	 * @return Collection<TKey,T>
	 */
	public function matching(Criteria $criteria);
}