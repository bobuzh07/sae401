<?php

namespace App\Controller;

use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; // Import pour le format JSON
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Annotation\Groups;

final class DepartementController extends AbstractController
{

    #[Route('/api/departements', name: 'app_departement_api', methods: ['GET'])]
    public function index(DepartementRepository $repository): JsonResponse
    {
        // On récupère la liste des départements depuis la base de données
        $departements = $repository->findAll();

        // On utilise la méthode json() héritée de AbstractController (voir TD 3)
        // 'groups' permet de sélectionner les propriétés à envoyer (définies dans l'Entité)
        return $this->json($departements, 200, [], [
            'groups' => ['dep:read']
        ]);
    }
}