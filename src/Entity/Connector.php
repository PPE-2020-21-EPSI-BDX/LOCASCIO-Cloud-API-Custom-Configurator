<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ConnectorRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Connector', 'read:Disk', 'read:RaidCard'],
                'enable_max_depth' => true
            ]
        ]
    ]
)]
class Connector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Connector'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    #[Groups(['read:Connector'])]
    private ?string $max_transfert_speed;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: Disk::class, orphanRemoval: true)]
    #[Groups(['read:Disk'])]
    #[MaxDepth(1)]
    private ArrayCollection $disks;

    #[ORM\ManyToMany(targetEntity: RaidCard::class, mappedBy: 'outputs_to_disks')]
    #[ORM\JoinTable("raid_card_interface")]
    #[ORM\JoinColumn("connector_id", "id")]
    #[Groups(['read:RaidCard'])]
    #[MaxDepth(1)]
    private ArrayCollection $raidCards;

    public function __construct()
    {
        $this->disks = new ArrayCollection();
        $this->raidCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxTransfertSpeed(): ?string
    {
        return $this->max_transfert_speed;
    }

    public function setMaxTransfertSpeed(?string $max_transfert_speed): self
    {
        $this->max_transfert_speed = $max_transfert_speed;

        return $this;
    }

    /**
     * @return Collection<int, Disk>
     */
    public function getDisks(): Collection
    {
        return $this->disks;
    }

    public function addDisk(Disk $disk): self
    {
        if (!$this->disks->contains($disk)) {
            $this->disks[] = $disk;
            $disk->setInterface($this);
        }

        return $this;
    }

    public function removeDisk(Disk $disk): self
    {
        if ($this->disks->removeElement($disk)) {
            // set the owning side to null (unless already changed)
            if ($disk->getInterface() === $this) {
                $disk->setInterface(null);
            }
        }

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
            $raidCard->addOutputsToDisk($this);
        }

        return $this;
    }

    public function removeRaidCard(RaidCard $raidCard): self
    {
        if ($this->raidCards->removeElement($raidCard)) {
            $raidCard->removeOutputsToDisk($this);
        }

        return $this;
    }
}
