<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $numeroReservation = null;

    #[ORM\Column(nullable: false)]
    private ?\DateTime $dateReservation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Foodtruck $foodtruck = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneau $creneauReserve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroReservation(): ?string
    {
        return $this->numeroReservation;
    }

    public function setNumeroReservation(string $numeroReservation): static
    {
        $this->numeroReservation = $numeroReservation;

        return $this;
    }

    public function getDateReservation(): ?\DateTime
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTime $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getFoodtruck(): ?Foodtruck
    {
        return $this->foodtruck;
    }

    public function setFoodtruck(?Foodtruck $foodtruck): static
    {
        $this->foodtruck = $foodtruck;

        return $this;
    }

    public function getCreneauReserve(): ?Creneau
    {
        return $this->creneauReserve;
    }

    public function setCreneauReserve(?Creneau $creneauReserve): static
    {
        $this->creneauReserve = $creneauReserve;

        return $this;
    }

    public function generateNumeroReservation(): string
    {
        if ($this->id !== null && $this->dateReservation !== null) {
            $this->numeroReservation = $this->id . $this->dateReservation->format('Ymd');

            return $this->numeroReservation;
        }
    }
}
