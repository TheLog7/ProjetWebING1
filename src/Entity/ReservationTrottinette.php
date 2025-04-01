<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\ReservationTrottinetteRepository")]
class ReservationTrottinette
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Trottinette::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Trottinette $trottinette;

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

    public function getTrottinette(): Trottinette
    {
        return $this->trottinette;
    }

    public function setTrottinette(Trottinette $trottinette): self
    {
        $this->trottinette = $trottinette;

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
