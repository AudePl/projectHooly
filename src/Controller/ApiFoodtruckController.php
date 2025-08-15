<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\FoodtruckRepository;
use App\Entity\Foodtruck;

#[Route('/api', name: 'api_')]
final class ApiFoodtruckController extends AbstractController
{
    #[Route('/foodtrucks', name: 'foodtrucks', methods: ['GET'])]
    public function getAllFoodtrucks(SerializerInterface $serializer, FoodtruckRepository $FoodtruckRepository): JsonResponse
    {

        $allFoodtrucks = $FoodtruckRepository->findAll();
        $json = $serializer->serialize($allFoodtrucks, 'json');

        return $this->json($json);

    }

    #[Route('/foodtrucks', name: 'foodtrucks_create', methods: ['POST'])]
    public function createOneFoodtruck(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
 
        $foodtruck = new Foodtruck();
        $foodtruck->setNom($data['nom']);
        $foodtruck->setDescription($data['description']);
        $foodtruck->setTypeCuisine($data['typeCuisine']);
        $foodtruck->setEmail($data['email']);

        $em->persist($foodtruck);
        $em->flush();
        
        return $this->json(['id' => $foodtruck->getId()], 201);

    }

    #[Route('/foodtrucks/{id}', name: 'foodtruck_detail', methods: ['GET'])]
    public function getOneFoodtruck(int $id, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {

        $foodtruck = $entityManager->getRepository(Foodtruck::class)->find($id);
        $json = $serializer->serialize($foodtruck, 'json');

        return $this->json($json);

    }
}
