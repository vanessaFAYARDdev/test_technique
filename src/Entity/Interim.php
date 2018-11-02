<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterimRepository")
 */
class Interim
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Merci de saisir un prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Merci de saisir un nom")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="Merci de saisir un code postal")
     * @Assert\Regex("\d{2}[ ]?\d{3}")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="interim")
     */
    private $contracts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MissionTracking", mappedBy="interim")
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getName(): ?string
    {
        $name = $this->firstName . ' ' . $this->lastName;
        return $name;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

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
            $contract->setInterim($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->contains($contract)) {
            $this->contracts->removeElement($contract);
            // set the owning side to null (unless already changed)
            if ($contract->getInterim() === $this) {
                $contract->setInterim(null);
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
            $missionTracking->setInterim($this);
        }

        return $this;
    }

    public function removeMissionTracking(MissionTracking $missionTracking): self
    {
        if ($this->missionTrackings->contains($missionTracking)) {
            $this->missionTrackings->removeElement($missionTracking);
            // set the owning side to null (unless already changed)
            if ($missionTracking->getInterim() === $this) {
                $missionTracking->setInterim(null);
            }
        }

        return $this;
    }

    public function __toString(): ?string
    {
        $name = $this->lastName . $this->firstName;
        return $name;
    }
}
