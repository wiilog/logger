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

    public function findInstance($instance) {
        return $this->createQueryBuilder("e")
            ->where("e.instance = :instance")
            ->setParameter("instance", $instance)
            ->getQuery();
    }

}
