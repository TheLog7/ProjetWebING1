<?php

namespace App\Entity;

use App\Repository\ReservationOrdinateurRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ordinateur;
use App\Entity\Utilisateur;


#[ORM\Entity(repositoryClass: ReservationOrdinateurRepository::class)]
class ReservationOrdinateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ordinateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ordinateur $ordinateur = null;

    #[ORM\ManyToOne(targetEntity: utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?utilisateur $utilisateur = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateReservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdinateur(): ?ordinateur
    {
        return $this->ordinateur;
    }

    public function setOrdinateur(ordinateur $ordinateur): self
    {
        $this->ordinateur = $ordinateur;

        return $this;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }
}
