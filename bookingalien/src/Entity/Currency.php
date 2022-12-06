<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $currencyName = null;

    #[ORM\Column(length: 255)]
    private ?string $currencySymbol = null;

    #[ORM\Column]
    private ?float $currencyExchangeRate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): self
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getCurrencySymbol(): ?string
    {
        return $this->currencySymbol;
    }

    public function setCurrencySymbol(string $currencySymbol): self
    {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }

    public function getCurrencyExchangeRate(): ?float
    {
        return $this->currencyExchangeRate;
    }

    public function setCurrencyExchangeRate(float $currencyExchangeRate): self
    {
        $this->currencyExchangeRate = $currencyExchangeRate;

        return $this;
    }
}
