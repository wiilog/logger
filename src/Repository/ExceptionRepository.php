<?php

namespace App\Repository;

use App\Entity\Exception;
use Doctrine\ORM\EntityRepository;

/**
 * @method Exception|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exception|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exception[]    findAll()
 * @method Exception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExceptionRepository extends EntityRepository {

    public function queryOrdered() {
        return $this->createQueryBuilder("e")
            ->orderBy("e.time", "DESC")
            ->getQuery();
    }

    public function queryInstance($instance) {
        return $this->createQueryBuilder("e")
            ->where("e.instance = :instance")
            ->orderBy("e.time", "DESC")
            ->setParameter("instance", $instance)
            ->getQuery();
    }

}
