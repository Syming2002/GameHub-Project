<?php

namespace App\Repository;

use App\Entity\PartyGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartyGame>
 */
class PartyGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartyGame::class);
    }

    /**
     * Search the party games by name.
     *
     * @return PartyGame[] Returns an array of Oeuvre objects
     */
    public function searchByTitle(string $partyGameName): array {
        return $this->createQueryBuilder('pg')
            ->andWhere("pg.partyGameName LIKE :partyGameName")
            ->setParameter("partyGameName", '%' . $partyGameName . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return PartyGame[] Returns an array of PartyGame objects
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

//    public function findOneBySomeField($value): ?PartyGame
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
