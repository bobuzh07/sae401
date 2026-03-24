<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// --- TRÈS IMPORTANT : Pour que le Controller puisse lire les données ---
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Le code département ne peut pas être vide")]
    // On expose le code
    #[Groups(['dep:read'])]
    private ?string $code_departement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du département ne peut pas être vide")]
    // On expose le nom
    #[Groups(['dep:read'])]
    private ?string $nom_departement = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    #[ORM\JoinColumn(name: "region_code", referencedColumnName: "code_region", nullable: false)]
    // On expose la région liée (attention, il faudra aussi des Groups dans Region.php)
    #[Groups(['dep:read'])]
    private ?Region $region = null;

    /**
     * @var Collection<int, Statistique>
     */
    #[ORM\OneToMany(targetEntity: Statistique::class, mappedBy: 'departement', orphanRemoval: true)]
    // On expose la liste des statistiques pour ce département
    #[Groups(['dep:read'])]
    private Collection $statistiques;

    public function __construct()
    {
        $this->statistiques = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Statistique>
     */
    public function getStatistiques(): Collection
    {
        return $this->statistiques;
    }

    public function addStatistique(Statistique $statistique): static
    {
        if (!$this->statistiques->contains($statistique)) {
            $this->statistiques->add($statistique);
            $statistique->setDepartement($this);
        }
        return $this;
    }

    public function removeStatistique(Statistique $statistique): static
    {
        if ($this->statistiques->removeElement($statistique)) {
            if ($statistique->getDepartement() === $this) {
                $statistique->setDepartement(null);
            }
        }
        return $this;
    }
}