<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @extends ServiceEntityRepository<Participant>
 */
class ParticipantRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Participant::class);
        $this->logger = $logger;
    }

    public function loadUserByIdentifier(string $identifier): ?Participant
    {
        $entityManager = $this->getEntityManager();

        $result = $entityManager->createQuery(
            'SELECT p
                FROM App\Entity\Participant p
                WHERE p.pseudo = :pseudo
                OR p.mail = :mail'
        )
            ->setParameter('pseudo', $identifier)
            ->setParameter('mail', $identifier)
            ->getOneOrNullResult();

        $this->logger->warning('loadUserByIdentifier');

        return $result;
    }

    //    /**
    //     * @return Participant[] Returns an array of Participant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Participant
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
