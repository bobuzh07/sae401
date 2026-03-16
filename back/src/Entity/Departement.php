<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Le code département ne peut pas être vide")]
    private ?string $code_departement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du département ne peut pas être vide")]
    private ?string $nom_departement = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    #[ORM\JoinColumn(name: "region_code", referencedColumnName: "code_region", nullable: false)]
    private ?Region $region = null;


    public function getCodeDepartement(): ?string
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(string $code_departement): static
    {
        $this->code_departement = $code_departement;
        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): static
    {
        $this->nom_departement = $nom_departement;
        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;
        return $this;
    }
}