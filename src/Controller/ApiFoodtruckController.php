<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FoodtruckRepository;
use App\Entity\Foodtruck;

#[Route('/api', name: 'api_')]
final class ApiFoodtruckController extends AbstractController
{
    #[Route('/foodtrucks', name: 'foodtrucks', methods: ['GET'])]
    public function getAllFoodtrucks(FoodtruckRepository $FoodtruckRepository): JsonResponse
    {

        try{
            $allFoodtrucks = $FoodtruckRepository->findAll();
            $data = [];
        
            foreach ($allFoodtrucks as $foodtruck) {
            $data[] = [
                'idFoodtruck' => $foodtruck->getId(),
                'nom' => $foodtruck->getNom(),
                'description' => $foodtruck->getDescription(),
                'typeCuisine' => $foodtruck->getTypeCuisine(),
                'email' => $foodtruck->getEmail(),
            ];
            }

            return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/foodtrucks', name: 'foodtrucks_create', methods: ['POST'])]
    public function createOneFoodtruck(Request $request, EntityManagerInterface $em): JsonResponse
    {
        try{
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
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/foodtrucks/{id}', name: 'foodtruck_detail', methods: ['GET'])]
    public function getOneFoodtruck(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        try{
            $foodtruck = $entityManager->getRepository(Foodtruck::class)->find($id);
            
            if($foodtruck ) {

                $data = [
                    'idFoodtruck' => $foodtruck->getId(),
                    'nom' => $foodtruck->getNom(),
                    'description' => $foodtruck->getDescription(),
                    'typeCuisine' => $foodtruck->getTypeCuisine(),
                    'email' => $foodtruck->getEmail(),
                ];

            } else {
                return $this->json("Aucun foodtruck correspondant à l'id " .  $id);
            }
            
            
            return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }
}
