<?php

namespace App\Entity;

use App\Repository\RaidCardLevelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaidCardLevelRepository::class)]
class RaidCardLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: RaidCard::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?RaidCard $raid_card;

    #[ORM\ManyToOne(targetEntity: Level::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Level $level;

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
