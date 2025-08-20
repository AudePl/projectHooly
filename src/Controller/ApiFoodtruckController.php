<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FoodtruckRepository;
use App\Entity\Foodtruck;

#[Route('/api', name: 'api_')]
final class ApiFoodtruckController extends AbstractController
{
    #[Route('/foodtrucks', name: 'foodtrucks', methods: ['GET'])]
    #[OA\Get(
        summary: "Liste des foodtrucks",
        operationId: 'getFoodtruckList',
    )]
    #[OA\Response(
        response: 200,
        description: 'Retourne la liste des foodtruck',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'idFoodtruckd', type: 'integer', example: 42),
                    new OA\Property(property: 'nom', type: 'string', example: 'Thai Landais'),
                    new OA\Property(property: 'description', type: 'string', example: 'Un foodtruck de cuisine Fusion'),
                    new OA\Property(property: 'typeCuisine', type: 'string', example: 'Thailandaise'),
                    new OA\Property(property: 'email', type: 'string', example: 'thailandais@hotmail.fr')
                ]
            )
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Requête invalide'
    )]
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
    #[OA\Post(
        summary: "Creation d'un nouveau foodtruck",
        operationId: 'createNewFoodtruck',
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            required: ['nom', 'description', 'typeCuisine', 'email'],
            properties: [
                new OA\Property(property: 'nom', type: 'string', example: 'Thai Landais'),
                new OA\Property(property: 'description', type: 'string', example: 'Un foodtruck de cuisine Fusion'),
                new OA\Property(property: 'typeCuisine', type: 'string', example: 'Thailandaise'),
                new OA\Property(property: 'email', type: 'string', example: 'thailandais@hotmail.fr')
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Retourne l'id du nouveau foodtruck"
    )]
    #[OA\Response(
        response: 400,
        description: 'Requête invalide'
    )]
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
    #[OA\Get(
        summary: "Detail d'un foodtruck",
        operationId: 'getFoodtruckDetail',
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Identifiant unique du foodtruck',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', example: 42)
    )]
    #[OA\Response(
        response: 200,
        description: "Retourne le detail d'un foodtruck",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'iidFoodtruckd', type: 'integer', example: 42),
                new OA\Property(property: 'nom', type: 'string', example: 'Thai Landais'),
                new OA\Property(property: 'description', type: 'string', example: 'Un foodtruck de cuisine Fusion'),
                new OA\Property(property: 'typeCuisine', type: 'string', example: 'Thailandaise'),
                new OA\Property(property: 'email', type: 'string', example: 'thailandais@hotmail.fr')
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Requête invalide'
    )]
    #[OA\Response(
        response: 404,
        description: 'Parametre invalide, aucune ressource trouvée'
    )]
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
                return $this->json(["Aucun foodtruck correspondant à l'id " .  $id], 404);
            }
            
            
            return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }
}
