<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'tripID')]
    private ?int $tripID = null;

    #[ORM\Column(name:'tripStart', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $tripStart = null;

    #[ORM\Column(name:'tripEnd', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $tripEnd = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(name:'travellerEmail', referencedColumnName:'travellerEmail', nullable: false)]
    private ?Traveller $travellerEmail = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'activityID', referencedColumnName:'activityID' ,nullable: false)]
    private ?Activity $activityID = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'hotelID', referencedColumnName:'hotelID', nullable: false)]
    private ?Hotel $hotelID = null;

    public function getId(): ?int
    {
        return $this->tripID;
    }

    public function getTripID(): ?int
    {
        return $this->tripID;
    }

    public function setTripID(int $tripID): self
    {
        $this->tripID = $tripID;

        return $this;
    }

    public function getTripStart(): ?\DateTimeInterface
    {
        return $this->tripStart;
    }

    public function setTripStart(\DateTimeInterface $tripStart): self
    {
        $this->tripStart = $tripStart;

        return $this;
    }

    public function getTripEnd(): ?\DateTimeInterface
    {
        return $this->tripEnd;
    }

    public function setTripEnd(\DateTimeInterface $tripEnd): self
    {
        $this->tripEnd = $tripEnd;

        return $this;
    }

    public function getTravellerEmail(): ?Traveller
    {
        return $this->travellerEmail;
    }

    public function setTravellerEmail(?Traveller $travellerEmail): self
    {
        $this->travellerEmail = $travellerEmail;

        return $this;
    }

    public function getActivityID(): ?Activity
    {
        return $this->activityID;
    }

    public function setActivityID(?Activity $activityID): self
    {
        $this->activityID = $activityID;

        return $this;
    }

    public function getHotelID(): ?Hotel
    {
        return $this->hotelID;
    }

    public function setHotelID(?Hotel $hotelID): self
    {
        $this->hotelID = $hotelID;

        return $this;
    }
}
