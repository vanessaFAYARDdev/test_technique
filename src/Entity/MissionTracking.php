<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MissionTrackingRepository")
 */
class MissionTracking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(message="Merci de saisir une note")
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "la note doit être supérieur à {{ limit }}",
     *      maxMessage = "la note doit être inférieur à {{ limit }}"
     * )
     */
    private $score;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contract", inversedBy="missionTracking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Interim", inversedBy="missionTrackings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $interim;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status", inversedBy="missionTrackings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(Contract $contract): self
    {
        $this->contract = $contract;

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
}
