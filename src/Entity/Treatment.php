<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $frequency = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_taking_time = null;

    /**
     * @var Collection<int, MedecineBox>
     */
    #[ORM\OneToMany(targetEntity: MedecineBox::class, mappedBy: 'treatment')]
    private Collection $Medecine_boxes;

    /**
     * @var Collection<int, TreatmentTime>
     */
    #[ORM\OneToMany(targetEntity: TreatmentTime::class, mappedBy: 'treatment')]
    private Collection $treatment_times;

    public function __construct()
    {
        $this->Medecine_boxes = new ArrayCollection();
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
     * @return Collection<int, MedecineBox>
     */
    public function getMedecineBoxes(): Collection
    {
        return $this->Medecine_boxes;
    }

    public function addMedecineBox(MedecineBox $medecineBox): static
    {
        if (!$this->Medecine_boxes->contains($medecineBox)) {
            $this->Medecine_boxes->add($medecineBox);
            $medecineBox->setTreatment($this);
        }

        return $this;
    }

    public function removeMedecineBox(MedecineBox $medecineBox): static
    {
        if ($this->Medecine_boxes->removeElement($medecineBox)) {
            // set the owning side to null (unless already changed)
            if ($medecineBox->getTreatment() === $this) {
                $medecineBox->setTreatment(null);
            }
        }

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
}
