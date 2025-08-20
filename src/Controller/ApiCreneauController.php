<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CreneauRepository;
use App\Entity\Campus;
use App\Entity\Creneau;
use App\Entity\Reservation;

#[Route('/api', name: 'api_')]
final class ApiCreneauController extends AbstractController
{
    #[Route('/creneaux', name: 'creneaux', methods: ['GET'])]
    #[OA\Get(
        summary: "Liste des créneaux",
        operationId: 'getCreneauxList',
    )]
    #[OA\Response(
        response: 200,
        description: 'Retourne la liste des creneaux',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'idCreneau', type: 'integer', example: 42),
                    new OA\Property(property: 'nom', type: 'string', example: 'Emplacement A'),
                    new OA\Property(property: 'jourSemaine', type: 'string', example: 'Lundi'),
                    new OA\Property(property: 'campus', type: 'string', example: 'Paris')
                ]
            )
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Requête invalide'
    )]
    public function getAllCreneau(CreneauRepository $creneauRepository): JsonResponse
    {

        try{
            $allCreneaux = $creneauRepository->findAll();
            $data = [];
        
            foreach ($allCreneaux as $creneau) {
                $data[] = [
                        'idCreneau' => $creneau->getId(),
                        'nom' => $creneau->getNumeroNom(),
                        'jourSemaine' => $creneau->getJourSemaine()->getNom(),
                        'campus' => $creneau->getCampus()->getVille(),
                ];
            }

            return $this->json($data);
        }
        catch(\Exception $e){

            //@TODO : mise en place d'exception technique et fonctionnelle
            return $this->json(['ERROR' => $e->getMessage()], 400);

        }

    }

    #[Route('/disponibilites/{campus}/{date}', name: 'disponibilites_campus_date', methods: ['GET'])]
    #[OA\Get(
        summary: "Liste des disponibilités pour un campus et une date donnés",
        operationId: 'getDisponibilitiesList',
    )]
    #[OA\Response(
        response: 200,
        description: 'Retourne la liste des disponibilités pour un campus et une date donnés',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'idCreneau', type: 'integer', example: 42),
                    new OA\Property(property: 'nomEmplacement', type: 'string', example: 'Emplacement A'),
                    new OA\Property(property: 'campus', type: 'string', example: 'Paris'),
                    new OA\Property(property: 'jourSemaine', type: 'string', example: '2Lundi')
                ]
            )
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Requête invalide'
    )]
    public function getDisponibiliteByCampusByDate(string $campus, string $date, EntityManagerInterface $entityManager): JsonResponse
    {
        try{
                $dateObjet = \DateTime::createFromFormat('Ymd', $date);
                $campusEntity = $entityManager->getRepository(Campus::class)->findOneBy(['ville' => $campus]);
                
                if ($dateObjet && $campusEntity) {

                    $resa = $entityManager->getRepository(Reservation::class)->findByCampusAndDate($dateObjet, $campusEntity);

                    $DispoByCampus = $entityManager->getRepository(Creneau::class)->findByCampusAndDate($dateObjet, $campusEntity);
                    $data = [];
                    
                    foreach ($DispoByCampus as $disponibilite) {
                            $data[] = [
                                'idCreneau' => $disponibilite->getId(),
                                'nomEmplacement' => $disponibilite->getNumeroNom(),
                                'campus' => $disponibilite->getCampus(),
                                'jourSemaine' => $disponibilite->getJourSemaine(),
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
}
