<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hotelID = null;

    #[ORM\Column(length: 255)]
    private ?string $hotelName = null;

    #[ORM\Column(length: 255)]
    private ?string $hotelAdress = null;

    #[ORM\Column]
    private ?float $hotelZip = null;

    #[ORM\Column]
    private ?int $hotelNbPlace = null;

    #[ORM\Column]
    private ?float $hotelPrice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $cityID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHotelID(): ?int
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

    public function getHotelAdress(): ?string
    {
        return $this->hotelAdress;
    }

    public function setHotelAdress(string $hotelAdress): self
    {
        $this->hotelAdress = $hotelAdress;

        return $this;
    }

    public function getHotelZip(): ?float
    {
        return $this->hotelZip;
    }

    public function setHotelZip(float $hotelZip): self
    {
        $this->hotelZip = $hotelZip;

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
