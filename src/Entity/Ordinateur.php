<?php

namespace App\Entity;

use App\Repository\OrdinateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdinateurRepository::class)]
class Ordinateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $marque = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 50)]
    private ?string $numeroSerie = null;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['Disponible', 'En maintenance', 'Hors service', 'Indisponible'])]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $localisation = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $niveauBatterie = null;

    #[ORM\Column(type: "date", nullable: true)]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\Column(type: "date", nullable: true)]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $derniere_maintenance = null;

    #[ORM\Column]
    private bool $est_en_service = true;

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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;
        return $this;
    }

    public function getNumeroSerie(): ?string
    {
    return $this->numeroSerie;
    }

    public function setNumeroSerie(string $numeroSerie): static
    {
    $this->numeroSerie = $numeroSerie;
    return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;
        return $this;
    }

    public function getNiveauBatterie(): ?int
    {
        return $this->niveauBatterie;
    }

    public function setNiveauBatterie(?int $niveauBatterie): self
    {
        $this->niveauBatterie = $niveauBatterie;

        return $this;
    }


    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(?\DateTimeInterface $date_achat): static
    {
        $this->date_achat = $date_achat;
        return $this;
    }

    public function getDerniereMaintenance(): ?\DateTimeInterface
    {
        return $this->derniere_maintenance;
    }

    public function setDerniereMaintenance(?\DateTimeInterface $derniere_maintenance): static
    {
        $this->derniere_maintenance = $derniere_maintenance;
        return $this;
    }

    public function isEstEnService(): bool
    {
        return $this->est_en_service;
    }

    public function setEstEnService(bool $est_en_service): static
    {
        $this->est_en_service = $est_en_service;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->nom, $this->numeroSerie);
    }
}
