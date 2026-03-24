<?php

namespace App\Entity;

use App\Repository\StatistiqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StatistiqueRepository::class)]
class Statistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?int $annee = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?float $taux_chomage = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?float $taux_pauvrete = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?float $taux_logement_individuels = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?float $moins_20ans = null;

    #[ORM\Column]
    #[Groups(['dep:read'])]
    private ?float $plus_60ans = null;

    // --- NOUVEAU CHAMP AJOUTÉ ---
    #[ORM\Column(nullable: true)]
    #[Groups(['dep:read'])]
    private ?int $nb_habitant = null;

    #[ORM\ManyToOne(inversedBy: 'statistiques')]
    #[ORM\JoinColumn(name: "departement_code", referencedColumnName: "code_departement", nullable: false)]
    private ?Departement $departement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;
        return $this;
    }

    public function getTauxChomage(): ?float
    {
        return $this->taux_chomage;
    }

    public function setTauxChomage(float $taux_chomage): static
    {
        $this->taux_chomage = $taux_chomage;
        return $this;
    }

    public function getTauxPauvrete(): ?float
    {
        return $this->taux_pauvrete;
    }

    public function setTauxPauvrete(float $taux_pauvrete): static
    {
        $this->taux_pauvrete = $taux_pauvrete;
        return $this;
    }

    public function getTauxLogementIndividuels(): ?float
    {
        return $this->taux_logement_individuels;
    }

    public function setTauxLogementIndividuels(float $taux_logement_individuels): static
    {
        $this->taux_logement_individuels = $taux_logement_individuels;
        return $this;
    }

    public function getMoins20ans(): ?float
    {
        return $this->moins_20ans;
    }

    public function setMoins20ans(float $moins_20ans): static
    {
        $this->moins_20ans = $moins_20ans;
        return $this;
    }

    public function getPlus60ans(): ?float
    {
        return $this->plus_60ans;
    }

    public function setPlus60ans(float $plus_60ans): static
    {
        $this->plus_60ans = $plus_60ans;
        return $this;
    }

    // --- GETTER ET SETTER POUR NB_HABITANT ---
    public function getNbHabitant(): ?int
    {
        return $this->nb_habitant;
    }

    public function setNbHabitant(?int $nb_habitant): static
    {
        $this->nb_habitant = $nb_habitant;
        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;
        return $this;
    }
}