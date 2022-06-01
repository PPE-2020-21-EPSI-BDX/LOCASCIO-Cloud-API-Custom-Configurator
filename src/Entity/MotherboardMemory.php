<?php

namespace App\Entity;

use App\Repository\MotherboardMemoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotherboardMemoryRepository::class)]
class MotherboardMemory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Motherboard $motherboard;

    #[ORM\ManyToOne(targetEntity: Memory::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Memory $memory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }

    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }

    public function getMemory(): ?Memory
    {
        return $this->memory;
    }

    public function setMemory(?Memory $memory): self
    {
        $this->memory = $memory;

        return $this;
    }
}
