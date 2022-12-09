<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'hotelID')]
    private ?int $hotelID = null;

    #[ORM\Column(name:'hotelName', length: 255)]
    private ?string $hotelName = null;

    #[ORM\Column(name:'hotelAddress', length: 255)]
    private ?string $hotelAddress = null;

    #[ORM\Column(name: 'hotelNbPlace')]
    private ?int $hotelNbPlace = null;

    #[ORM\Column(name: 'hotelPrice')]
    private ?float $hotelPrice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'cityID', referencedColumnName:'cityID', nullable: false)]
    private ?City $cityID = null;

    public function getId(): ?int
    {
        return $this->hotelID;
    }

    public function setHotelID(int $hotelID): self
    {
        $this->hotelID = $hotelID;

        return $this;
    }

    public function getHotelName(): ?string
    {
        return $this->hotelName;
    }

    public function setHotelName(string $hotelName): self
    {
        $this->hotelName = $hotelName;

        return $this;
    }

    public function getHotelAddress(): ?string
    {
        return $this->hotelAddress;
    }

    public function setHotelAddress(string $hotelAddress): self
    {
        $this->hotelAddress = $hotelAddress;

        return $this;
    }

    public function getHotelNbPlace(): ?int
    {
        return $this->hotelNbPlace;
    }

    public function setHotelNbPlace(int $hotelNbPlace): self
    {
        $this->hotelNbPlace = $hotelNbPlace;

        return $this;
    }

    public function getHotelPrice(): ?float
    {
        return $this->hotelPrice;
    }

    public function setHotelPrice(float $hotelPrice): self
    {
        $this->hotelPrice = $hotelPrice;

        return $this;
    }

    public function getCityID(): ?City
    {
        return $this->cityID;
    }

    public function setCityID(?City $cityID): self
    {
        $this->cityID = $cityID;

        return $this;
    }
}
