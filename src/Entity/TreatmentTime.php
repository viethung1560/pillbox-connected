<?php

namespace App\Entity;

use App\Repository\TreatmentTimeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TreatmentTimeRepository::class)]
class TreatmentTime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getTreatment"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(["getTreatment"])]
    private ?\DateTimeInterface $time = null;

    #[ORM\ManyToOne(inversedBy: 'treatment_times')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getTreatment","getTreatmentTime"])]
    private ?Treatment $treatment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(?Treatment $treatment): static
    {
        $this->treatment = $treatment;

        return $this;
    }
}
