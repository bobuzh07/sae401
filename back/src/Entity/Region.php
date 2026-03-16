<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    #[Assert\NotBlank]
    private ?string $code_region = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom_region = null;


    #[ORM\OneToMany(targetEntity: Departement::class, mappedBy: 'region')]
    private Collection $departements;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }
    public function setCodeRegion(string $code_region): static
    {
        $this->code_region = $code_region;
        return $this;
    }

    public function getCodeRegion(): ?string
    {
        return $this->code_region;
    }

    public function getNomRegion(): ?string
    {
        return $this->nom_region;
    }

    public function setNomRegion(string $nom_region): static
    {
        $this->nom_region = $nom_region;
        return $this;
    }

    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): static
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setRegion($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getRegion() === $this) {
                $departement->setRegion(null);
            }
        }

        return $this;
    }
}