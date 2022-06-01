<?php

namespace App\Entity;

use App\Repository\MotherboardInterfaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotherboardInterfaceRepository::class)]
class MotherboardInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Motherboard $motherboard;

    #[ORM\ManyToOne(targetEntity: Connector::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Connector $connector;

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

    public function getConnector(): ?Connector
    {
        return $this->connector;
    }

    public function setConnector(?Connector $connector): self
    {
        $this->connector = $connector;

        return $this;
    }
}
