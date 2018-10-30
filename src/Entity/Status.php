<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="status")
     */
    private $contracts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MissionTracking", mappedBy="status")
     */
    private $missionTrackings;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->missionTrackings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->setStatus($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->contains($contract)) {
            $this->contracts->removeElement($contract);
            // set the owning side to null (unless already changed)
            if ($contract->getStatus() === $this) {
                $contract->setStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MissionTracking[]
     */
    public function getMissionTrackings(): Collection
    {
        return $this->missionTrackings;
    }

    public function addMissionTracking(MissionTracking $missionTracking): self
    {
        if (!$this->missionTrackings->contains($missionTracking)) {
            $this->missionTrackings[] = $missionTracking;
            $missionTracking->setStatus($this);
        }

        return $this;
    }

    public function removeMissionTracking(MissionTracking $missionTracking): self
    {
        if ($this->missionTrackings->contains($missionTracking)) {
            $this->missionTrackings->removeElement($missionTracking);
            // set the owning side to null (unless already changed)
            if ($missionTracking->getStatus() === $this) {
                $missionTracking->setStatus(null);
            }
        }

        return $this;
    }
}
