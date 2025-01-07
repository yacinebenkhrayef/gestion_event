<?php
// src/Entity/Participation.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipationRepository;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participant $participant = null;

    #[ORM\ManyToOne(targetEntity: Collaboration::class, inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collaboration $collaboration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;
        return $this;
    }

    public function getCollaboration(): ?Collaboration
    {
        return $this->collaboration;
    }

    public function setCollaboration(?Collaboration $collaboration): self
    {
        $this->collaboration = $collaboration;
        return $this;
    }
}

