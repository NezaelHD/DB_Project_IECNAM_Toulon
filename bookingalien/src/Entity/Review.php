<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'reviewID')]
    private ?int $reviewID = null;

    #[ORM\Column(name:'reviewOpinion', length: 255)]
    private ?string $reviewOpinion = null;

    #[ORM\Column(name:'reviewStars')]
    private ?int $reviewStars = null;

    #[ORM\ManyToOne]
    private ?Hotel $hotelID = null;

    #[ORM\ManyToOne]
    private ?Activity $activityID = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'travellerEmail', nullable: false)]
    private ?Traveller $travellerEmail = null;

    public function getId(): ?int
    {
        return $this->reviewID;
    }

    public function setReviewID(int $reviewID): self
    {
        $this->reviewID = $reviewID;

        return $this;
    }

    public function getReviewOpinion(): ?string
    {
        return $this->reviewOpinion;
    }

    public function setReviewOpinion(string $reviewOpinion): self
    {
        $this->reviewOpinion = $reviewOpinion;

        return $this;
    }

    public function getReviewStars(): ?int
    {
        return $this->reviewStars;
    }

    public function setReviewStars(int $reviewStars): self
    {
        $this->reviewStars = $reviewStars;

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

    public function getActivityID(): ?Activity
    {
        return $this->activityID;
    }

    public function setActivityID(?Activity $activityID): self
    {
        $this->activityID = $activityID;

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
}
