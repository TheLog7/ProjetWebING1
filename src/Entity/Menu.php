<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $entree = null;

    #[ORM\Column(length: 255)]
    private ?string $plat = null;

    #[ORM\Column(length: 255)]
    private ?string $dessert = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEntree(): ?string
    {
        return $this->entree;
    }

    public function setEntree(string $entree): static
    {
        $this->entree = $entree;

        return $this;
    }

    public function getPlat(): ?string
    {
        return $this->plat;
    }

    public function setPlat(string $plat): static
    {
        $this->plat = $plat;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->dessert;
    }

    public function setDessert(string $dessert): static
    {
        $this->dessert = $dessert;

        return $this;
    }
}
