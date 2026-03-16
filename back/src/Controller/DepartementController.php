<?php

namespace App\Controller;

use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(DepartementRepository $repository): Response
    {
        // On récupère tous les départements chargés via tes fixtures
        $departements = $repository->findAll();

        return $this->render('departement/index.html.twig', [
            'liste_departements' => $departements,
        ]);
    }
}