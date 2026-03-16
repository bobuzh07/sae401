<?php

namespace App\DataFixtures;

use App\Entity\Region;
use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. Lire le fichier JSON
        $json = file_get_contents('public/import/data.json');
        $data = json_decode($json, true);

        $regionsCreees = [];

        foreach ($data as $item) {
            
            // TRI DES REGIONS
            if (!isset($regionsCreees[$item['code_region']])) {
                $region = new Region();
                $region->setCodeRegion($item['code_region']);
                $region->setNomRegion($item['nom_region']);
                $manager->persist($region);
                
                $regionsCreees[$item['code_region']] = $region;
            }

            // CREATION DES DEPARTEMENTS
            $dept = new Departement();
            $dept->setCodeDepartement($item['code_departement']);
            $dept->setNomDepartement($item['nom_departement']);
            $dept->setRegion($regionsCreees[$item['code_region']]);

            $manager->persist($dept);
        }

        $manager->flush();
    }
}