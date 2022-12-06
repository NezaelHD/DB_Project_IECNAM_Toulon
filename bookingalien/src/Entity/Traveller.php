<?php

namespace App\Entity;

use App\Repository\TravellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravellerRepository::class)]
class Traveller
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $travellerEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $travellerName = null;

    #[ORM\Column(length: 255)]
    private ?string $travellerSurname = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $planetName = null;

    #[ORM\OneToMany(mappedBy: 'travellerEmail', targetEntity: Trip::class, orphanRemoval: true)]
    private Collection $trips;

    public function __construct()
    {
        $this->trips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTravellerEmail(): ?string
    {
        return $this->travellerEmail;
    }

    public function setTravellerEmail(string $travellerEmail): self
    {
        $this->travellerEmail = $travellerEmail;

        return $this;
    }

    public function getTravellerName(): ?string
    {
        return $this->travellerName;
    }

    public function setTravellerName(string $travellerName): self
    {
        $this->travellerName = $travellerName;

        return $this;
    }

    public function getTravellerSurname(): ?string
    {
        return $this->travellerSurname;
    }

    public function setTravellerSurname(string $travellerSurname): self
    {
        $this->travellerSurname = $travellerSurname;

        return $this;
    }

    public function getPlanetName(): ?Planet
    {
        return $this->planetName;
    }

    public function setPlanetName(?Planet $planetName): self
    {
        $this->planetName = $planetName;

        return $this;
    }

    /**
     * @return Collection<int, Trip>
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips->add($trip);
            $trip->setTravellerEmail($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getTravellerEmail() === $this) {
                $trip->setTravellerEmail(null);
            }
        }

        return $this;
    }
}
