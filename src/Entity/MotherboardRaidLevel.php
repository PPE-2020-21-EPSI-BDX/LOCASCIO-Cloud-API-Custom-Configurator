<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MotherboardRaidLevelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotherboardRaidLevelRepository::class)]
#[ApiResource(
    collectionOperations: ['post'],
    itemOperations: []
)]
class MotherboardRaidLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Motherboard $motherboard;

    #[ORM\ManyToOne(targetEntity: Level::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Level $level;

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

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }
}
