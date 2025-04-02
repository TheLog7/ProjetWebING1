<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\VeloRepository")]
class Velo
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank(message: "L'ID unique ne peut pas être vide.")]
    private string $identifiantUnique;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    private string $marque;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $niveauBatterie = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $statut;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $derniereInteraction = null;



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

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

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

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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
    public function getType(): string
{
    return 'velo';
}


}
