<?php

namespace App\Repository;

use App\Entity\InstanceUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InstanceUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstanceUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstanceUser[]    findAll()
 * @method InstanceUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstanceRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, InstanceUser::class);
    }

}
