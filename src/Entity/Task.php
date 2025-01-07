<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Collaboration::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collaboration $collaboration = null;

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
