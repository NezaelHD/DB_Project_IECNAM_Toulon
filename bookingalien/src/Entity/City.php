<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'cityID')]
    private ?int $cityID = null;

    #[ORM\Column(name:'cityName', length: 255)]
    private ?string $cityName = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(name:'countryName', referencedColumnName:'countryName', nullable: false)]
    private ?Country $countryName = null;

    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'cities')]
    #[ORM\JoinTable(name:'CityActivities')]
    #[ORM\JoinColumn(name: 'cityID', referencedColumnName: 'cityID')]
    #[ORM\InverseJoinColumn(name: 'activityID', referencedColumnName: 'activityID')]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }
}
