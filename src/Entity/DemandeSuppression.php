<?php

namespace App\Entity;

use App\Repository\DemandeSuppressionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeSuppressionRepository::class)]
class DemandeSuppression
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeToSuppress = null;

    #[ORM\Column]
    private ?int $idToSuppress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeToSuppress(): ?string
    {
        return $this->typeToSuppress;
    }

    public function setTypeToSuppress(string $typeToSuppress): static
    {
        $this->typeToSuppress = $typeToSuppress;

        return $this;
    }

    public function getIdToSuppress(): ?int
    {
        return $this->idToSuppress;
    }

    public function setIdToSuppress(int $idToSuppress): static
    {
        $this->idToSuppress = $idToSuppress;

        return $this;
    }
}
