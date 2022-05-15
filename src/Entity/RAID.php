<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RAIDRepository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: RAIDRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Motherboard', 'read:FormFactor', 'read:Motherboard_detail', 'read:Processor', 'read:Memory'],
                'enable_max_depth' => true
            ]
        ]
    ]
)]
class RAID
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Raid'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Raid'])]
    private string $raid_level;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Raid'])]
    private string $interface_support;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Raid'])]
    private string $data_transfer_rate;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Raid'])]
    private int $nbr_port_sas;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Raid'])]
    private int  $nbr_port_sata;

    #[ORM\OneToMany(mappedBy: 'raid_support', targetEntity: Motherboard::class)]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Collection $motherboards;

    #[ORM\ManyToOne(targetEntity: PCIE::class, inversedBy: 'raids')]
    #[Groups(['read:PCIE'])]
    #[MaxDepth(1)]
    private Collection $pcie;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Raid'])]
    private ?string $availability;

    #[ORM\Column(type: 'datetime',  nullable: true)]
    #[Groups(['read:Raid'])]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Raid'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:Raid'])]
    private ?Decimal $price;

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

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(?string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getDelivery(): ?\DateTimeInterface
    {
        return $this->delivery;
    }

    public function setDelivery(\DateTimeInterface $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getProviderReference(): ?string
    {
        return $this->provider_reference;
    }

    public function setProviderReference(?string $provider_reference): self
    {
        $this->provider_reference = $provider_reference;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getInterfaceSupport(): ?string
    {
        return $this->interface_support;
    }

    public function setInterfaceSupport(?string $interface_support): self
    {
        $this->interface_support = $interface_support;

        return $this;
    }
}
