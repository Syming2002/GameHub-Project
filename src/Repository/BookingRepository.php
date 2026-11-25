<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\PartyGame;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

   public function searchByUserAndPartyGame(User $user, PartyGame $partyGame): ?Booking
   {
       return $this->createQueryBuilder('b')
            ->andWhere('b.user = :user')
            ->andWhere('b.partyGame = :partyGame')
            ->setParameter('user', $user)
            ->setParameter('partyGame', $partyGame)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
       ;
   }


//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
