<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La matière est obligatoire.")]
    private ?string $matiere = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "L'enseignant est obligatoire.")]
    private ?Utilisateur $enseignant = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La classe est obligatoire.")]
    private ?string $classe = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La salle est obligatoire.")]
    private ?string $salle = null;

    #[ORM\Column]
    #[Assert\GreaterThan("now", message: "La date de début doit être dans le futur.")]
    private ?\DateTime $debut = null;

    #[ORM\Column]
    #[Assert\GreaterThan(propertyPath: "debut", message: "La date de fin doit être après la date de début.")]
    private ?\DateTime $fin = null;

    // Relation ManyToMany avec Utilisateur (élèves ou professeurs)
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'cours')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): static
    {
        $this->matiere = $matiere;
        return $this;
    }

    public function getEnseignant(): ?Utilisateur
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Utilisateur $enseignant): static
    {
        $this->enseignant = $enseignant;
        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): static
    {
        $this->classe = $classe;
        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): static
    {
        $this->salle = $salle;
        return $this;
    }

    public function getDebut(): ?\DateTime
    {
        return $this->debut;
    }

    public function setDebut(\DateTime $debut): static
    {
        $this->debut = $debut;
        return $this;
    }

    public function getFin(): ?\DateTime
    {
        return $this->fin;
    }

    public function setFin(\DateTime $fin): static
    {
        $this->fin = $fin;
        return $this;
    }

    // Getter pour récupérer les utilisateurs associés à ce cours
    public function getUsers(): Collection
    {
        return $this->users;
    }

    // Méthodes pour ajouter et enlever un utilisateur associé à ce cours
    public function addUser(Utilisateur $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(Utilisateur $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
