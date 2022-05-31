<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\RackIndicatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackIndicatorRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [],
    ],
    paginationItemsPerPage: 1,
    paginationMaximumItemsPerPage: 1
)]
#[ApiFilter(SearchFilter::class, properties: ['rack' => 'exact'])]
class RackIndicator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Rack $rack;

    #[ORM\ManyToOne(targetEntity: Indicator::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Indicator $indicator;

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
