<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'professeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?utilisateur $id_utilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $Matiere = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?utilisateur $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->Matiere;
    }

    public function setMatiere(string $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }

}
