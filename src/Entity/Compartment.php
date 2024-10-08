<?php

namespace App\Entity;

use App\Repository\CompartmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompartmentRepository::class)]
class Compartment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $state = null;

    #[ORM\Column]
    private ?int $pill_number = null;

    #[ORM\OneToOne(inversedBy: 'compartment', cascade: ['persist', 'remove'])]
    private ?MedecineBox $medecine_box = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getPillNumber(): ?int
    {
        return $this->pill_number;
    }

    public function setPillNumber(int $pill_number): static
    {
        $this->pill_number = $pill_number;

        return $this;
    }

    public function getMedecineBox(): ?MedecineBox
    {
        return $this->medecine_box;
    }

    public function setMedecineBox(?MedecineBox $medecine_box): static
    {
        $this->medecine_box = $medecine_box;

        return $this;
    }
}
