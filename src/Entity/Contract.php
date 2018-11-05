<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 */
class Contract
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Interim", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $interim;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MissionTracking", mappedBy="contract", cascade={"persist", "remove"})
     */
    private $missionTracking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getInterim(): ?Interim
    {
        return $this->interim;
    }

    public function setInterim(?Interim $interim): self
    {
        $this->interim = $interim;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMissionTracking(): ?MissionTracking
    {
        return $this->missionTracking;
    }

    public function setMissionTracking(MissionTracking $missionTracking): self
    {
        $this->missionTracking = $missionTracking;

        // set the owning side of the relation if necessary
        if ($this !== $missionTracking->getContract()) {
            $missionTracking->setContract($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->id;
    }
}
