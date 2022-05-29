<?php

namespace App\Entity;

use App\Repository\RackFormFactorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackFormFactorRepository::class)]
class RackFormFactor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Rack $rack;

    #[ORM\ManyToOne(targetEntity: FormFactor::class)]
    #[ORM\JoinColumn(nullable: false)]
    private FormFactor $rack_unit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRackUnit(): ?FormFactor
    {
        return $this->rack_unit;
    }

    public function setRackUnit(?FormFactor $rack_unit): self
    {
        $this->rack_unit = $rack_unit;

        return $this;
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

}
