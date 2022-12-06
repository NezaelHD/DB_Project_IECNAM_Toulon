<?php

namespace App\Entity;

use App\Repository\TravellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: TravellerRepository::class)]
#[UniqueEntity(fields: ['travellerEmail'], message: 'There is already an account with this travellerEmail')]
class Traveller implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $travellerEmail = null;

    #[ORM\Column(type: 'json')]
    private ?array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password;

    #[ORM\Column(length: 255)]
    private ?string $travellerName = null;

    #[ORM\Column(length: 255)]
    private ?string $travellerSurname = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $planetName = null;

    #[ORM\OneToMany(mappedBy: 'travellerEmail', targetEntity: Trip::class, orphanRemoval: true)]
    private Collection $trips;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

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

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->travellerEmail;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
