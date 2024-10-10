<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getTreatment"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["getTreatment"])]
    private ?int $frequency = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["getTreatment"])]
    private ?\DateTimeInterface $last_taking_time = null;

    /**
     * @var Collection<int, MedecineBox>
     */

    /**
     * @var Collection<int, TreatmentTime>
     */
    #[ORM\OneToMany(targetEntity: TreatmentTime::class, mappedBy: 'treatment')]
    private Collection $treatment_times;

    #[ORM\Column]
    #[Groups(["getTreatment"])]
    private ?int $compartement = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MedecineBox $medecine_box = null;

    public function __construct()
    {
        $this->treatment_times = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getLastTakingTime(): ?\DateTimeInterface
    {
        return $this->last_taking_time;
    }

    public function setLastTakingTime(?\DateTimeInterface $last_taking_time): static
    {
        $this->last_taking_time = $last_taking_time;

        return $this;
    }

    /**
     * @return Collection<int, TreatmentTime>
     */
    public function getTreatmentTimes(): Collection
    {
        return $this->treatment_times;
    }

    public function addTreatmentTime(TreatmentTime $treatmentTime): static
    {
        if (!$this->treatment_times->contains($treatmentTime)) {
            $this->treatment_times->add($treatmentTime);
            $treatmentTime->setTreatment($this);
        }

        return $this;
    }

    public function removeTreatmentTime(TreatmentTime $treatmentTime): static
    {
        if ($this->treatment_times->removeElement($treatmentTime)) {
            // set the owning side to null (unless already changed)
            if ($treatmentTime->getTreatment() === $this) {
                $treatmentTime->setTreatment(null);
            }
        }

        return $this;
    }

    public function getCompartement(): ?int
    {
        return $this->compartement;
    }

    public function setCompartement(int $compartement): static
    {
        $this->compartement = $compartement;

        return $this;
    }

    public function getMedecineBox(): ?MedecineBox
    {
        return $this->medecine_box;
    }

    public function setMedecineBox(MedecineBox $medecine_box): static
    {
        $this->medecine_box = $medecine_box;

        return $this;
    }

}
