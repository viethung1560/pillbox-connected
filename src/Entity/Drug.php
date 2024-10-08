<?php

namespace App\Entity;

use App\Repository\DrugRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrugRepository::class)]
class Drug
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $CIS = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $dosage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $indication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contraindication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondary_effect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCIS(): ?string
    {
        return $this->CIS;
    }

    public function setCIS(string $CIS): static
    {
        $this->CIS = $CIS;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function getIndication(): ?string
    {
        return $this->indication;
    }

    public function setIndication(?string $indication): static
    {
        $this->indication = $indication;

        return $this;
    }

    public function getContraindication(): ?string
    {
        return $this->contraindication;
    }

    public function setContraindication(?string $contraindication): static
    {
        $this->contraindication = $contraindication;

        return $this;
    }

    public function getSecondaryEffect(): ?string
    {
        return $this->secondary_effect;
    }

    public function setSecondaryEffect(?string $secondary_effect): static
    {
        $this->secondary_effect = $secondary_effect;

        return $this;
    }
}
