<?php

namespace App\Entity;

use App\Repository\JourDisponibleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JourDisponibleRepository::class)]
class JourDisponible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $codePhp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePhp(): ?int
    {
        return $this->codePhp;
    }

    public function setCodePhp(int $codePhp): static
    {
        $this->codePhp = $codePhp;

        return $this;
    }
}
