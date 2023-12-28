<?php

namespace App\Repository;

use App\Entity\Exception;
use App\Entity\Instance;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @method Exception|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exception|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exception[]    findAll()
 * @method Exception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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

}
