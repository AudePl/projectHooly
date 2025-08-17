<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use App\Entity\Campus;
use App\Entity\Creneau;
use App\Entity\Foodtruck;

class ReservationService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function reservationIsValid(\DateTime $dateReservation, Foodtruck $foodtruck, Campus $campus): bool
    {
        try{

            // NOTE : Les choix techniques arbitraires sont des notions ou j'ai pris une decision pour ce test, mais sur un projet ce sont des points ou j'echange avec le client pour etre certaine de la regle

            $isValid = true;

            if( !$this->verifyReservationDeadline($dateReservation)) {
                // La date n'est pas valide
                $isValid = false;
                return $isValid;
            }


            if ( !$this->verifyFoodtruckNotPresentOnOtherCampus($dateReservation, $foodtruck)) {
                // Le foodtruck a deja une reservation sur un autre campus pour ce jour
                $isValid = false;
                return $isValid;
            }

            if ( !$this->verifyFoodtruckByCampusByWeek($dateReservation, $foodtruck, $campus)) {
                // Le foodtruck a deja une reservation sur ce campus dans la semaine en cours
                $isValid = false;
                return $isValid;
            }

            return $isValid;
                
        }
        catch(\Exception $e){

         //@TODO : mise en place d'exception technique et fonctionnelle

        }

    }

    private function verifyReservationDeadline(\DateTime $dateReservation): bool
    {
        // RG : Les réservations doivent être effectuées au moins 1 jour à l'avance
        // Un foodtruck ne peut pas réserver pour le jour même ni pour une date passée 

        // Choix technique arbitraire 1 : 1 jour a l'avance = J-1 avant minuit
        // Choix technique arbitraire 2 : Pas de fuseau horaires a gerer

        $demain = new \DateTime('tomorrow');

        // Ignore l'heure pour une comparaison du jour uniquement
        $dateReservation->setTime(0, 0);
        $demain->setTime(0, 0);

        return $dateReservation >= $demain;

    }

    private function verifyFoodtruckNotPresentOnOtherCampus(\DateTime $dateReservation, Foodtruck $foodtruck): bool
    {
        // RG : Un foodtruck ne peut pas être présent sur les deux campus le même jour (= Un foodtruck ne peut pas avoir au moins une autre reservation pour le meme jour)

        // Recuperation des reservations pour le foodtruck concerne pour la date concernee :
        $resaAllReadyExist = $this->entityManager->getRepository(Reservation::class)->findByFoodtruckAndDate($dateReservation, $foodtruck);

        $isPossibleForFoodtruck = empty($resaAllReadyExist);

        return $isPossibleForFoodtruck;

    }

    private function verifyFoodtruckByCampusByWeek(\DateTime $dateReservation, Foodtruck $foodtruck, Campus $campus): bool
    {
        //RG : Chaque foodtruck peut réserver au maximum 1 emplacement par campus par semaine (= Un foodtruck ne peut pas avoir au moins une autre reservation sur le meme campus la meme semaine)
   
        // Choix technique arbitraire 1 : par semaine = lundi a vendredi ET NON date + 1 semaine (ex de mardi a mardi)

        // Recuperation des reservations pour le foodtruck concerne sur le campus concerne pour la semaine concernee :
        $resaAllReadyExist = $this->entityManager->getRepository(Reservation::class)->findByCampusAndFoodtruckAndDate($dateReservation, $foodtruck, $campus);

        $isPossibleForFoodtruck = empty($resaAllReadyExist);

        return $isPossibleForFoodtruck;
   
    }

}