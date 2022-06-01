<?php

namespace App\Entity;

use App\Repository\MotherboardProcessorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotherboardProcessorRepository::class)]
class MotherboardProcessor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Motherboard $motherboard;

    #[ORM\ManyToOne(targetEntity: Processor::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Processor $processor;

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

    public function getProcessor(): ?Processor
    {
        return $this->processor;
    }

    public function setProcessor(?Processor $processor): self
    {
        $this->processor = $processor;

        return $this;
    }
}
