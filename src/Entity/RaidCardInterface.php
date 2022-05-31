<?php

namespace App\Entity;

use App\Repository\RaidCardInterfaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaidCardInterfaceRepository::class)]
class RaidCardInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: RaidCard::class)]
    private $raid_card;

    #[ORM\ManyToOne(targetEntity: Connector::class)]
    private $connector;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaidCard(): ?RaidCard
    {
        return $this->raid_card;
    }

    public function setRaidCard(?RaidCard $raid_card): self
    {
        $this->raid_card = $raid_card;

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
