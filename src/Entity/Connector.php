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
                'groups' => ['read:Connector', 'read:Disk', 'read:Raid', 'read:Motherboard'],
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

    #[ORM\OneToMany(mappedBy: 'connector', targetEntity: RAID::class, orphanRemoval: true)]
    #[Groups(['read:Raid'])]
    #[MaxDepth(1)]
    private ArrayCollection $raid_cards;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'interface')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private ArrayCollection $motherboards;

    public function __construct()
    {
        $this->disks = new ArrayCollection();
        $this->raid_cards = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
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
     * @return Collection<int, RAID>
     */
    public function getRaidCards(): Collection
    {
        return $this->raid_cards;
    }

    public function addRaidCard(RAID $raidCard): self
    {
        if (!$this->raid_cards->contains($raidCard)) {
            $this->raid_cards[] = $raidCard;
            $raidCard->setConnector($this);
        }

        return $this;
    }

    public function removeRaidCard(RAID $raidCard): self
    {
        if ($this->raid_cards->removeElement($raidCard)) {
            // set the owning side to null (unless already changed)
            if ($raidCard->getConnector() === $this) {
                $raidCard->setConnector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Motherboard>
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }

    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addInterface($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeInterface($this);
        }

        return $this;
    }
}
