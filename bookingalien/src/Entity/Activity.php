<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'activityID')]
    private ?int $activityID = null;

    #[ORM\Column(name:'activityName', length: 255)]
    private ?string $activityName = null;

    #[ORM\Column(name: 'activityPrice')]
    private ?float $activityPrice = null;

    public function getId(): ?int
    {
        return $this->activityID;
    }

    public function getActivityID(): ?int
    {
        return $this->activityID;
    }

    public function setActivityID(int $activityID): self
    {
        $this->activityID = $activityID;

        return $this;
    }

    public function getActivityName(): ?string
    {
        return $this->activityName;
    }

    public function setActivityName(string $activityName): self
    {
        $this->activityName = $activityName;

        return $this;
    }

    public function getActivityPrice(): ?float
    {
        return $this->activityPrice;
    }

    public function setActivityPrice(float $activityPrice): self
    {
        $this->activityPrice = $activityPrice;

        return $this;
    }
}
