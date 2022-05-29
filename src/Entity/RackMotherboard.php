<?php

namespace App\Entity;

use App\Repository\RackMotherboardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackMotherboardRepository::class)]
class RackMotherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $rack;

    #[ORM\ManyToOne(targetEntity: Motherboard::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRack(): ?Rack
    {
        return $this->rack;
    }

    public function setRack(?Rack $rack): self
    {
        $this->rack = $rack;

        return $this;
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
}
