<?php

namespace App\DataFixtures;

use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\Statistique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. On récupère le JSON
        $json = file_get_contents('public/import/data.json');
        $data = json_decode($json, true);

        $regionsCreees = [];
        $deptsCrees = [];

        foreach ($data as $item) {
            
            // --- A. LA RÉGION ---
            if (!isset($regionsCreees[$item['code_region']])) {
                $region = new Region();
                $region->setCodeRegion($item['code_region']);
                $region->setNomRegion($item['nom_region']);
                $manager->persist($region);
                $regionsCreees[$item['code_region']] = $region;
            }

            // --- B. LE DÉPARTEMENT ---
            if (!isset($deptsCrees[$item['code_departement']])) {
                $dept = new Departement();
                $dept->setCodeDepartement($item['code_departement']);
                $dept->setNomDepartement($item['nom_departement']);
                $dept->setRegion($regionsCreees[$item['code_region']]);
                $manager->persist($dept);
                $deptsCrees[$item['code_departement']] = $dept;
            }
            
            // --- C. LA STATISTIQUE ---
            $stat = new Statistique();

            $stat->setAnnee((int)$item['annee']); 

            // Utilise EXACTEMENT les clés de ton JSON
            $stat->setTauxChomage((float)($item['taux_chaumage'] ?? 0));
            $stat->setTauxPauvrete((float)($item['taux_pauvrete'] ?? 0));
            $stat->setTauxLogementIndividuels((float)($item['taux_logement_individuels'] ?? 0));

            // Pour les âges
            $stat->setMoins20ans((float)($item['moins_20ans'] ?? 0));
            $stat->setPlus60ans((float)($item['plus_60ans'] ?? 0));

            // --- LA LIGNE À AJOUTER EST ICI ---
            $stat->setNbHabitant((int)($item['nb_habitant'] ?? 0));

            // On lie au département
            $stat->setDepartement($deptsCrees[$item['code_departement']]);

            $manager->persist($stat);
        }

        $manager->flush();
    }
}