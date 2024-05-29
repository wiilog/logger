<?php

namespace App\Repository;

use App\Entity\Instance;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ExceptionRepository extends EntityRepository {

    public function queryOrdered(): Query {
        return $this->createQueryBuilder("e")
            ->orderBy("e.time", "DESC")
            ->getQuery();
    }

    public function queryInstance(Instance $instance): Query {
        return $this->createQueryBuilder("e")
            ->andWhere("e.instance = :instance")
            ->orderBy("e.time", "DESC")
            ->setParameter("instance", $instance)
            ->getQuery();
    }

    public function iterateOlderThan(\DateTime $dateTime): iterable {
        return $this->createQueryBuilder("exception")
            ->andWhere("exception.time < :time")
            ->setParameter("time", $dateTime)
            ->getQuery()
            ->toIterable();
    }

}
