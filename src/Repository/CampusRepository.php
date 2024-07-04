<?php

namespace App\Repository;

use App\Entity\Campus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campus>
 */
class CampusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campus::class);
    }

    public function findAllAsChoices(): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        return $queryBuilder
            ->select('c.id AS id, c.nom AS nom')
            ->getQuery()
            ->getArrayResult();
    }
}
