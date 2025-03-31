<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\ImprimanteRepository")]
class Imprimante
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank(message: "L'ID unique ne peut pas être vide.")]
    private string $identifiantUnique;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    private string $nom;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $modele = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $niveauBatterie = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $niveauEncre = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $derniereInteraction = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La salle est obligatoire.")]
    private ?string $salle = null;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiantUnique(): string
    {
        return $this->identifiantUnique;
    }

    public function setIdentifiantUnique(string $identifiantUnique): self
    {
        $this->identifiantUnique = $identifiantUnique;

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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

    public function getNiveauEncre(): ?int
    {
        return $this->niveauEncre;
    }

    public function setNiveauEncre(?int $niveauEncre): self
    {
        $this->niveauEncre = $niveauEncre;

        return $this;
    }

    public function getDerniereInteraction(): ?\DateTimeInterface
    {
        return $this->derniereInteraction;
    }

    public function setDerniereInteraction(?\DateTimeInterface $derniereInteraction): self
    {
        $this->derniereInteraction = $derniereInteraction;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(?string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}
