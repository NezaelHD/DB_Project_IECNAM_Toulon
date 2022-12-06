<?php

namespace App\Entity;

use App\Repository\PlanetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
class Planet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $planetName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanetName(): ?string
    {
        return $this->planetName;
    }

    public function setPlanetName(string $planetName): self
    {
        $this->planetName = $planetName;

        return $this;
    }
}
