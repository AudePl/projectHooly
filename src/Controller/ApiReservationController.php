<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use App\Entity\Campus;
use App\Entity\Creneau;
use App\Entity\Foodtruck;

#[Route('/api', name: 'api_')]
final class ApiReservationController extends AbstractController
{
    #[Route('/reservations', name: 'reservations', methods: ['GET'])]
    public function getAllReservations(SerializerInterface $serializer, ReservationRepository $ReservationRepository): JsonResponse
    {

        $allReservations = $ReservationRepository->findAll();
        $json = $serializer->serialize($allReservations, 'json');

        return $this->json($json);

    }

    #[Route('/reservations', name: 'reservations_create', methods: ['POST'])]
    public function createOneReservation(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
dump($data);
        $dateResa = \DateTime::createFromFormat('Ymd', $data['date']);
dump($dateResa);
        $foodtruck = $entityManager->getRepository(Foodtruck::class)->find((int) $data['idFoodtruck']);
dump($foodtruck);
        $creneau = $entityManager->getRepository(Creneau::class)->find((int) $data['idCreneau']);
dump($creneau);

        $reservation = new Reservation();
        $reservation->setDateReservation($dateResa);
        $reservation->setFoodtruck($foodtruck);
        $reservation->setCreneauReserve($creneau);

        $entityManager->persist($reservation);
        $entityManager->flush();
        
dump($reservation);

        $numeroResa = $reservation->generateNumeroReservation();
dump($numeroResa);

        $reservation->setNumeroReservation($numeroResa);

        $entityManager->persist($reservation);
        $entityManager->flush();
dd($reservation);    
        return $this->json(['Numero reservation' => $reservation->getNumeroReservation()], 201);
    }

    #[Route('/reservations/{campus}', name: 'reservations_campus', methods: ['GET'])]
    public function getAllReservationsByCampus(string $campus, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {

        $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $campus]);
        $creneaux = $entityManager->getRepository(Creneau::class)->findBy(['campus' => $campusEntity]);
        dump($creneaux);
        $reservationsByCampus = $entityManager->getRepository(Reservation::class)->findBy(['creneauReserve' => $creneaux]);
        dump($reservationsByCampus);
        $json = $serializer->serialize($reservationsByCampus, 'json');

        return $this->json($json);

    }

    #[Route('/reservations/{campus}/{date}', name: 'reservations_campus_date', methods: ['GET'])]
    public function getAllReservationsByCampusAndDate(string $campus, string $date, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $dateObjet = \DateTime::createFromFormat('Ymd', $date);
        dump($dateObjet);

        $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $campus]);
        $creneaux = $entityManager->getRepository(Creneau::class)->findBy(['campus' => $campusEntity]);
        dump($creneaux);
        $reservationsByCampus = $entityManager->getRepository(Reservation::class)->findBy(['creneauReserve' => $creneaux, 'dateReservation' => $dateObjet]);
        dump($reservationsByCampus);
        $json = $serializer->serialize($reservationsByCampus, 'json');

        return $this->json($json);

    }
}
