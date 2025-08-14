<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauRepository::class)]
class Creneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $numeroNom = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?JourDisponible $JourSemaine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroNom(): ?string
    {
        return $this->numeroNom;
    }

    public function setNumeroNom(string $numeroNom): static
    {
        $this->numeroNom = $numeroNom;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;

        return $this;
    }

    public function getJourSemaine(): ?JourDisponible
    {
        return $this->JourSemaine;
    }

    public function setJourSemaine(?JourDisponible $JourSemaine): static
    {
        $this->JourSemaine = $JourSemaine;

        return $this;
    }
}
