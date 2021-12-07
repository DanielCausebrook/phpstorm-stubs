<?php

namespace Doctrine\ORM;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @template T
 * @template-implements Selectable<int,T>
 * @template-implements ObjectRepository<T>
 */
class EntityRepository implements ObjectRepository, Selectable
{

    /**
     * @param ?int $lockMode
     * @param ?int $lockVersion
     *
     * @return ?T
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
    }

    /** @return list<T> */
    public function findAll()
    {
    }

    /**
     * @param ?int $limit
     * @param ?int $offset
     *
     * @return list<T>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
    }

    /** @return ?T */
    public function findOneBy(array $criteria, ?array $orderBy = null)
    {
    }

    /**
     * @return Collection<int,T>
     */
    public function matching(Criteria $criteria)
    {
    }
}
