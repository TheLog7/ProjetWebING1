<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReservationVeloRepository;
use App\Entity\Velo;
use App\Entity\Utilisateur;

#[ORM\Entity(repositoryClass: "App\Repository\ReservationVeloRepository")]
class ReservationVelo
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Velo::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Velo $velo;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateReservation;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVelo(): Velo
    {
        return $this->velo;
    }

    public function setVelo(Velo $velo): self
    {
        $this->velo = $velo;

        return $this;
    }

    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDateReservation(): \DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }
}
