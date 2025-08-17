<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use App\Entity\Reservation;
use App\Entity\Campus;
use App\Entity\Creneau;
use App\Entity\Foodtruck;

#[Route('/api', name: 'api_')]
final class ApiReservationController extends AbstractController
{
    #[Route('/reservations', name: 'reservations', methods: ['GET'])]
    public function getAllReservations(ReservationRepository $ReservationRepository): JsonResponse
    {
        try{
                $allReservations = $ReservationRepository->findAll();

                $data = [];
        
                foreach ($allReservations as $reservation) {
                        $data[] = [
                                'idReservation' => $reservation->getId(),
                                'numeroReservation' => $reservation->getNumeroReservation(),
                                'dateReservation' => $reservation->getDateReservation()->format('Y-m-d'),
                                'nomFoodtruck' => $reservation->getFoodtruck()->getNom(),
                                'typeCuisineFoodtruck' => $reservation->getFoodtruck()->getTypeCuisine(),
                                'emailFoodtruck' => $reservation->getFoodtruck()->getEmail(),
                                'nomCampus' => $reservation->getCreneauReserve()->getCampus()->getVille(),
                                'nomEmplacement' => $reservation->getCreneauReserve()->getNumeroNom(),
                        ];
                }

                return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/reservations', name: 'reservations_create', methods: ['POST'])]
    public function createOneReservation(Request $request, EntityManagerInterface $entityManager, ReservationService $reservationService): JsonResponse
    {
        // Creation d'une reservation : Reservation = 1 foodtruck + 1 date + 1 campus

        try{
                $data = json_decode($request->getContent(), true);

                $dateResa = \DateTime::createFromFormat('Ymd', $data['date']);

                $foodtruck = $entityManager->getRepository(Foodtruck::class)->find((int) $data['idFoodtruck']);

                // Formatage de la valeur reçue au format attendu dans BDD
                $ville = ucfirst(strtolower($data['campus']));
                $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $ville]);
                
                if ($dateResa && $foodtruck && $campusEntity) {

                    $demandeIsValid = $reservationService->reservationIsValid($dateResa, $foodtruck, $campusEntity);

                    if ($demandeIsValid) {
                        // Les differentes RG sont verifiees et validees : Enregistrement de la reservation

                        $reservation = new Reservation();
                        $reservation->setDateReservation($dateResa);
                        $reservation->setFoodtruck($foodtruck);


                        // Determiner un creneau disponible pour le campus et la date concerne a reserver
                        $DispoByCampus = $entityManager->getRepository(Creneau::class)->findByCampusAndDate($dateResa, $campusEntity);


                        if($DispoByCampus) {

                            // Recuperation du premier creneau disponible pour ce campus a cette date
                            $creneau = $DispoByCampus[0];
                            $reservation->setCreneauReserve($creneau);

                            $entityManager->persist($reservation);
                            $entityManager->flush();
                            
                            $numeroResa = $reservation->generateNumeroReservation();
                            $reservation->setNumeroReservation($numeroResa);

                            $entityManager->persist($reservation);
                            $entityManager->flush();
                    
                            return $this->json(['Numero reservation' => $reservation->getNumeroReservation()], 201);

                        } else {
                            return $this->json(['ERROR' => "Plus de disponibilite pour ce campus a cette date. Reservation impossible."], 409);

                        }
                        

                    } else {
                        return $this->json(['ERROR' => "Cette demande est en conflit avec les regles de gestion etablies, la demande n'a pas pu etre traitee"], 409);
                    }


                } else {

                    return $this->json(['ERROR' => "erreur sur les parametres"], 400);

                }

                
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }
    }

    #[Route('/reservations/{campus}', name: 'reservations_campus', methods: ['GET'])]
    public function getAllReservationsByCampus(string $campus, EntityManagerInterface $entityManager): JsonResponse
    {
        try{

            $ville = ucfirst(strtolower($campus));
            $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $ville]);

            $reservationsByCampus = $entityManager->getRepository(Reservation::class)->findByCampus($campusEntity);
            
            $data = [];
    
            foreach ($reservationsByCampus as $reservation) {
                    $data[] = [
                            'idReservation' => $reservation->getId(),
                            'numeroReservation' => $reservation->getNumeroReservation(),
                            'dateReservation' => $reservation->getDateReservation()->format('Y-m-d'),
                            'nomFoodtruck' => $reservation->getFoodtruck()->getNom(),
                            'typeCuisineFoodtruck' => $reservation->getFoodtruck()->getTypeCuisine(),
                            'emailFoodtruck' => $reservation->getFoodtruck()->getEmail(),
                            'nomCampus' => $reservation->getCreneauReserve()->getCampus()->getVille(),
                            'nomEmplacement' => $reservation->getCreneauReserve()->getNumeroNom(),
                    ];
            }

            return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/reservations/{campus}/{date}', name: 'reservations_campus_date', methods: ['GET'])]
    public function getAllReservationsByCampusAndDate(string $campus, string $date, EntityManagerInterface $entityManager): JsonResponse
    {
        try{
                $dateObjet = \DateTime::createFromFormat('Ymd', $date);
                $ville = ucfirst(strtolower($campus));
                $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $ville]);
                
                if ($dateObjet && $campusEntity) {
                        $reservationsByCampus = $entityManager->getRepository(Reservation::class)->findByCampusAndDate($dateObjet, $campusEntity);
                        $data = [];
                        
                        foreach ($reservationsByCampus as $reservation) {
                                $data[] = [
                                        'idReservation' => $reservation->getId(),
                                        'numeroReservation' => $reservation->getNumeroReservation(),
                                        'dateReservation' => $reservation->getDateReservation()->format('Y-m-d'),
                                        'nomFoodtruck' => $reservation->getFoodtruck()->getNom(),
                                        'typeCuisineFoodtruck' => $reservation->getFoodtruck()->getTypeCuisine(),
                                        'emailFoodtruck' => $reservation->getFoodtruck()->getEmail(),
                                        'nomCampus' => $reservation->getCreneauReserve()->getCampus()->getVille(),
                                        'nomEmplacement' => $reservation->getCreneauReserve()->getNumeroNom(),
                                ];
                        }

                        return $this->json($data);

                } else {
                     return $this->json(['Erreur sur les paramètres'], 400);   
                }
                
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/reservations/{id}', name: 'reservations_delete', methods: ['DELETE'])]
    public function deleteOneReservation(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        try{
            $reservation = $entityManager->getRepository(Reservation::class)->find($id);
            
            if($reservation) {

                $entityManager->remove($reservation);
                $entityManager->flush();
        
                return $this->json("Reservation supprimée avec succès correspondant à l'id " . $id);

            } else {

                return $this->json("Aucune reservation correspondant à l'id " .  $id);

            }
            
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }
}
