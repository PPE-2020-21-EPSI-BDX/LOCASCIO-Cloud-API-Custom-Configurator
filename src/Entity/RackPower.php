<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\RackPowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackPowerRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [],
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
#[ApiFilter(SearchFilter::class, properties: ['rack' => 'exact'])]
class RackPower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Rack $rack;

    #[ORM\ManyToOne(targetEntity: Power::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Power $power;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $power_supply_included;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $redundant_power;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPowerSupplyIncluded(): ?int
    {
        return $this->power_supply_included;
    }

    public function setPowerSupplyIncluded(?int $power_supply_included): self
    {
        $this->power_supply_included = $power_supply_included;

        return $this;
    }

    public function getRedundantPower(): ?int
    {
        return $this->redundant_power;
    }

    public function setRedundantPower(?int $redundant_power): self
    {
        $this->redundant_power = $redundant_power;

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

    public function getPower(): ?Power
    {
        return $this->power;
    }

    public function setPower(?Power $power): self
    {
        $this->power = $power;

        return $this;
    }
}
