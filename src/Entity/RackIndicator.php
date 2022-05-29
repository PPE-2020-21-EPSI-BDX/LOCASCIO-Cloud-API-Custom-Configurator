<?php

namespace App\Entity;

use App\Repository\RackIndicatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackIndicatorRepository::class)]
class RackIndicator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Rack $rack;

    #[ORM\ManyToOne(targetEntity: Indicator::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Indicator $indicator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRack(): Rack
    {
        return $this->rack;
    }

    public function setRack(?Rack $rack): self
    {
        $this->rack = $rack;

        return $this;
    }

    public function getIndicator(): ?Indicator
    {
        return $this->indicator;
    }

    public function setIndicator(?Indicator $indicator): self
    {
        $this->indicator = $indicator;

        return $this;
    }
}
