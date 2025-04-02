<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
#[ORM\Table(name: 'jeux')]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(name: "max_places", type: "integer")]
    private ?int $maxPlaces = null; 

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, ReservationJeux>
     */
    #[ORM\OneToMany(targetEntity: ReservationJeux::class, mappedBy: 'jeux')]
    private Collection $reservationsJeux;

    public function __construct()
    {
        $this->reservationsJeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMaxPlaces(): ?int
    {
        return $this->maxPlaces;
    }

    public function setMaxPlaces(int $max_places): self
    {
        $this->maxPlaces = $max_places;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ReservationJeux>
     */
    public function getReservationsjeux(): Collection
    {
        return $this->reservationsJeux;
    }

    public function addReservationsjeux(ReservationJeux $reservationsJeux): static
    {
        if (!$this->reservationsJeux->contains($reservationsJeux)) {
            $this->reservationsJeux->add($reservationsJeux);
            $reservationsJeux->setJeux($this);
        }

        return $this;
    }

    public function removeReservationsjeux(ReservationJeux $reservationsJeux): static
    {
        if ($this->reservationsJeux->removeElement($reservationsJeux)) {
            if ($reservationsJeux->getJeux() === $this) {
                $reservationsJeux->setJeux(null);
            }
        }

        return $this;
    }
}
