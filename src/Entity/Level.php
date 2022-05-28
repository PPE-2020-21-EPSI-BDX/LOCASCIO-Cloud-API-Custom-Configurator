<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Level', 'read:RaidCard'],
                'enable_max_depth' => true
            ]
        ],
        //'patch' => []
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Level'])]
    private int $level;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Level'])]
    private int $min_disk;

    #[ORM\ManyToMany(targetEntity: RaidCard::class, mappedBy: 'levels')]
    #[Groups(['read:RaidCard'])]
    private ArrayCollection $raidCards;

    public function __construct()
    {
        $this->raidCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMinDisk(): ?int
    {
        return $this->min_disk;
    }

    public function setMinDisk(int $min_disk): self
    {
        $this->min_disk = $min_disk;

        return $this;
    }

    /**
     * @return Collection<int, RaidCard>
     */
    public function getRaidCards(): Collection
    {
        return $this->raidCards;
    }

    public function addRaidCard(RaidCard $raidCard): self
    {
        if (!$this->raidCards->contains($raidCard)) {
            $this->raidCards[] = $raidCard;
            $raidCard->addLevel($this);
        }

        return $this;
    }

    public function removeRaidCard(RaidCard $raidCard): self
    {
        if ($this->raidCards->removeElement($raidCard)) {
            $raidCard->removeLevel($this);
        }

        return $this;
    }
}
