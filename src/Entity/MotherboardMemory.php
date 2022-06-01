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
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    private $motherboard;

    #[ORM\ManyToOne(targetEntity: Memory::class)]
    private $memory;

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
