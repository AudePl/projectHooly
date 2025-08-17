<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Campus;
use App\Entity\Foodtruck;


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

    /**
    * @return Reservation[] Returns an array of Reservation objects
    */
    public function findByFoodtruckAndDate(?\Datetime $date, ?Foodtruck $foodtruck): array
    {
        $start = (clone $date)->setTime(0, 0, 0);
        $end = (clone $date)->modify('+1 day')->setTime(0, 0, 0);

        return $this->createQueryBuilder('resa')
            ->where('resa.dateReservation >= :start')
            ->andWhere('resa.dateReservation < :end')
            ->andWhere('resa.foodtruck = :val')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('val', $foodtruck)
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Reservation[] Returns an array of Reservation objects
    */
    public function findByCampusAndFoodtruckAndDate(?\Datetime $date, ?Foodtruck $foodtruck, ?Campus $campus): array
    {

        $start = (clone $date)->modify('Monday this week')->setTime(0, 0, 0);
        $end = (clone $date)->modify('Sunday this week')->setTime(0, 0, 0);

        // Pour info : Si decisison client semaine courante et non semaine calendaire :
        // $start = (clone $date)->setTime(0, 0, 0);
        // $end = (clone $date)->modify('+7 days')->setTime(0, 0, 0);

        return $this->createQueryBuilder('resa')
            ->join('resa.creneauReserve', 'creneau')
            ->where('resa.dateReservation >= :start')
            ->andWhere('resa.dateReservation <= :end')
            ->andWhere('resa.foodtruck = :foodtruck')
            ->andWhere('creneau.campus = :campus')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('foodtruck', $foodtruck)
            ->setParameter('campus', $campus)
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
