<?php

namespace App\Repository;

use App\Entity\Creneau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Campus;
use App\Entity\Reservation;

/**
 * @extends ServiceEntityRepository<Creneau>
 */
class CreneauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneau::class);
    }

    /**
    * @return Creneau[] Returns an array of Creneau objects
    */
    public function findByCampusAndDate(?\Datetime $date, ?Campus $campus): array
    {
        $day = (int) $date->format('w');
        $start = (clone $date)->setTime(0, 0, 0);
        $end = (clone $date)->modify('+1 day')->setTime(0, 0, 0);

        $subQuery = $this->getEntityManager()->createQueryBuilder('resa')
            ->select('creneau.id')
            ->from('App\Entity\Reservation', 'resa')
            ->join('resa.creneauReserve', 'creneau')
            ->where('resa.dateReservation >= :start')
            ->andWhere('resa.dateReservation < :end')
            ->andWhere('creneau.campus = :val')
            ;
        

        $query = $this->createQueryBuilder('dispo');

        $query->join('dispo.jourSemaine', 'jour')
            ->where('dispo.campus = :val')
            ->andWhere('jour.codePhp = :day')
            ->andWhere($query->expr()->notIn('dispo.id', $subQuery->getDQL()))
            ->setParameter('val', $campus)
            ->setParameter('day', $day)
            ->setParameter('start', $start)
            ->setParameter('end', $end)            
        ;

        return $query->getQuery()->getResult();
        
    }

    //    public function findOneBySomeField($value): ?Creneau
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
