<?php

namespace App\Repository;

use App\Entity\Exception;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

/**
 * @method Exception|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exception|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exception[]    findAll()
 * @method Exception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExceptionRepository extends EntityRepository {

    public function findInstance(string $instance, string $mode) {
        return $this->createQueryBuilder("e")
            ->addSelect("COUNT(e.hash) AS count")
            ->where("e.instance = :instance")
            ->andWhere("e.mode = :mode")
            ->groupBy("e.hash")
            ->setParameter("instance", $instance)
            ->setParameter("mode", $mode)
            ->getQuery()->getResult();
    }

}
