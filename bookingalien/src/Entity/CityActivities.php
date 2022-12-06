<?php

namespace App\Entity;

use App\Repository\CityActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityActivitiesRepository::class)]
class CityActivities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Activity::class)]
    private Collection $activityName;

    #[ORM\ManyToMany(targetEntity: City::class)]
    private Collection $cityName;

    public function __construct()
    {
        $this->activityName = new ArrayCollection();
        $this->cityName = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivityName(): Collection
    {
        return $this->activityName;
    }

    public function addActivityName(Activity $activityName): self
    {
        if (!$this->activityName->contains($activityName)) {
            $this->activityName->add($activityName);
        }

        return $this;
    }

    public function removeActivityName(Activity $activityName): self
    {
        $this->activityName->removeElement($activityName);

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCityName(): Collection
    {
        return $this->cityName;
    }

    public function addCityName(City $cityName): self
    {
        if (!$this->cityName->contains($cityName)) {
            $this->cityName->add($cityName);
        }

        return $this;
    }

    public function removeCityName(City $cityName): self
    {
        $this->cityName->removeElement($cityName);

        return $this;
    }
}
