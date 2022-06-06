<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProcessorMemoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessorMemoryRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get']
)]
class ProcessorMemory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Processor::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Processor $processor;

    #[ORM\ManyToOne(targetEntity: Memory::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Memory $memory;

    public function getId(): ?int
    {
        return $this->id;
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
