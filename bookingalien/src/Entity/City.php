<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $cityID = null;

    #[ORM\Column(length: 255)]
    private ?string $cityName = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $countryName = null;

    public function getId(): ?int
    {
        return $this->cityID;
    }

    public function setCityID(int $cityID): self
    {
        $this->cityID = $cityID;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCountryName(): ?Country
    {
        return $this->countryName;
    }

    public function setCountryName(?Country $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }
}
