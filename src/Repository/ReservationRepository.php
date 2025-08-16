<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Campus;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
    * @return Reservation[] Returns an array of Reservation objects
    */
    public function findByCampus(?Campus $campus): array
    {
        
        return $this->createQueryBuilder('resa')
            ->join('resa.creneauReserve', 'creneau')
            ->where('creneau. campus= :val')
            ->setParameter('val', $campus)
            ->getQuery()
            ->getResult()
          ;
    }

    /**
    * @return Reservation[] Returns an array of Reservation objects
    */
    public function findByCampusAndDate(?\Datetime $date, ?Campus $campus): array
    {
        $start = (clone $date)->setTime(0, 0, 0);
        $end = (clone $date)->modify('+1 day')->setTime(0, 0, 0);

        return $this->createQueryBuilder('resa')
            ->join('resa.creneauReserve', 'creneau')
            ->where('resa.dateReservation >= :start')
            ->andWhere('resa.dateReservation < :end')
            ->andWhere('creneau.campus = :val')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('val', $campus)
            ->getQuery()
            ->getResult();
    }


    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
