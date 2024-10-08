<?php

namespace App\Entity;

use App\Repository\MedecineBoxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecineBoxRepository::class)]
class MedecineBox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $expiration_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $conditioning = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $manufacturer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Drug $drug = null;

    #[ORM\ManyToOne(inversedBy: 'medecine_boxes')]
    // 'usr' instead of 'user' since 'user' is a reserved word.
    private ?User $usr = null;

    #[ORM\OneToOne(mappedBy: 'medecine_box', cascade: ['persist', 'remove'])]
    private ?Compartment $compartment = null;

    #[ORM\ManyToOne(inversedBy: 'Medecine_boxes')]
    private ?Treatment $treatment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): static
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getConditioning(): ?int
    {
        return $this->conditioning;
    }

    public function setConditioning(?int $conditioning): static
    {
        $this->conditioning = $conditioning;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getDrug(): ?Drug
    {
        return $this->drug;
    }

    public function setDrug(?Drug $drug): static
    {
        $this->drug = $drug;

        return $this;
    }

    public function getUsr(): ?User
    {
        return $this->usr;
    }

    public function setUsr(?User $usr): static
    {
        $this->usr = $usr;

        return $this;
    }

    public function getCompartment(): ?Compartment
    {
        return $this->compartment;
    }

    public function setCompartment(?Compartment $compartment): static
    {
        // unset the owning side of the relation if necessary
        if ($compartment === null && $this->compartment !== null) {
            $this->compartment->setMedecineBox(null);
        }

        // set the owning side of the relation if necessary
        if ($compartment !== null && $compartment->getMedecineBox() !== $this) {
            $compartment->setMedecineBox($this);
        }

        $this->compartment = $compartment;

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
