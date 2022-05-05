<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RAIDRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: RAIDRepository::class)]
#[ApiResource]
class RAID
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $raid_level;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $interface_support;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $data_transfer_rate;

    #[ORM\Column(type: 'integer')]
    private int $nbr_port_sas;

    #[ORM\Column(type: 'integer')]
    private int  $nbr_port_sata;

    #[ORM\OneToMany(mappedBy: 'raid_support', targetEntity: Motherboard::class)]
    private Collection $motherboards;

    #[ORM\ManyToOne(targetEntity: PCIE::class, inversedBy: 'raids')]
    private Collection $pcie;

    #[Pure] public function __construct()
    {
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

    public function getRaidLevel(): ?string
    {
        return $this->raid_level;
    }

    public function setRaidLevel(?string $raid_level): self
    {
        $this->raid_level = $raid_level;

        return $this;
    }

    public function getInfaceSupport(): ?string
    {
        return $this->interface_support;
    }

    public function setInfaceSupport(?string $interface_support): self
    {
        $this->interface_support = $interface_support;

        return $this;
    }

    public function getDataTransferRate(): ?string
    {
        return $this->data_transfer_rate;
    }

    public function setDataTransferRate(?string $data_transfer_rate): self
    {
        $this->data_transfer_rate = $data_transfer_rate;

        return $this;
    }

    public function getPciExpressSlotVersion(): ?string
    {
        return $this->pci_express_slot_version;
    }

    public function setPciExpressSlotVersion(?string $pci_express_slot_version): self
    {
        $this->pci_express_slot_version = $pci_express_slot_version;

        return $this;
    }

    public function getHostInterface(): ?string
    {
        return $this->host_interface;
    }

    public function setHostInterface(?string $host_interface): self
    {
        $this->host_interface = $host_interface;

        return $this;
    }

    public function getNbrPortSas(): ?int
    {
        return $this->nbr_port_sas;
    }

    public function setNbrPortSas(int $nbr_port_sas): self
    {
        $this->nbr_port_sas = $nbr_port_sas;

        return $this;
    }

    public function getNbrPortSata(): int
    {
        return $this->nbr_port_sata;
    }

    public function setNbrPortSata(int $nbr_port_sata): self
    {
        $this->nbr_port_sata = $nbr_port_sata;

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
            $motherboard->setRaidSupport($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            // set the owning side to null (unless already changed)
            if ($motherboard->getRaidSupport() === $this) {
                $motherboard->setRaidSupport(null);
            }
        }

        return $this;
    }

    public function getPcie(): ?PCIE
    {
        return $this->pcie;
    }

    public function setPcie(?PCIE $pcie): self
    {
        $this->pcie = $pcie;

        return $this;
    }
}
