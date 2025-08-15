<?php

namespace App\Entity;

use App\Repository\FoodtruckRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['nom'], message: 'Ce nom de foodtruck existe déjà.')]
#[ORM\Entity(repositoryClass: FoodtruckRepository::class)]
class Foodtruck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $typeCuisine = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $email = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeCuisine(): ?string
    {
        return $this->typeCuisine;
    }

    public function setTypeCuisine(string $typeCuisine): static
    {
        $this->typeCuisine = $typeCuisine;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
