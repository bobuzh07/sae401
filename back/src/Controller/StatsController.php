<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StatsController extends AbstractController
{
    #[Route('/api/stats', name: 'app_stats')]
    public function index(): JsonResponse
    {
        // Prépare le chemin vers le fichier
        $path = $this->getParameter('kernel.project_dir') . '/public/import/data.json';

        // Vérifie si le fichier existe
        if (!file_exists($path)) {
            return $this->json(['error' => 'Fichier introuvable'], 404);
        }

        // Lit le contenu du fichier
        $jsonContent = file_get_contents($path);

        // Transforme le texte JSON en tableau PHP
        $data = json_decode($jsonContent, true);

        // Renvoie le résultat au format JSON
        return $this->json($data);
    }
}