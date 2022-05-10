<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MotherboardRepository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: MotherboardRepository::class)]
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
class Motherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Motherboard'])]
    private string $name;

    #[ORM\ManyToOne(targetEntity: FormFactor::class, inversedBy: 'motherboards')]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $form_factor;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $dimension;

    #[ORM\ManyToMany(targetEntity: Processor::class, inversedBy: 'motherboards')]
    #[Groups(['read:Processor'])]
    #[MaxDepth(1)]
    private Collection $processors;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $processor_note;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Motherboard_detail'])]
    private int $mem_slots;

    #[ORM\ManyToMany(targetEntity: Memory::class, inversedBy: 'motherboards')]
    #[Groups(['read:Memory'])]
    #[MaxDepth(1)]
    private Collection $mem_type;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?int $nbr_max_sata;

    #[ORM\ManyToOne(targetEntity: RAID::class, inversedBy: 'motherboards')]
    #[Groups(['read:Motherboard_detail'])]
    #[MaxDepth(1)]
    private Collection $raid_support;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $stata_speed;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?string $lan;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $usb;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $video_output;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $dom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $tpm;

    #[ORM\ManyToMany(targetEntity: PCIE::class, inversedBy: 'motherboards')]
    #[Groups(['read:Motherboard_detail'])]
    #[MaxDepth(1)]
    private Collection $pci_e_support;

    #[ORM\ManyToMany(targetEntity: M2::class, inversedBy: 'motherboards')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Collection $m2;

    #[ORM\ManyToMany(targetEntity: BareBone::class, mappedBy: 'motherboard')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private ArrayCollection $barbones;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?Decimal $price;

    #[Pure] public function __construct()
    {
        $this->processors = new ArrayCollection();
        $this->mem_type = new ArrayCollection();
        $this->pci_e_support = new ArrayCollection();
        $this->m2 = new ArrayCollection();
        $this->barbones = new ArrayCollection();
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

    public function getForFactor(): ?FormFactor
    {
        return $this->form_factor;
    }

    public function setForFactor(?FormFactor $form_factor): self
    {
        $this->form_factor = $form_factor;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(?string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Collection<int, Processor>
     */
    public function getProcessors(): Collection
    {
        return $this->processors;
    }

    public function addProcessor(Processor $processor): self
    {
        if (!$this->processors->contains($processor)) {
            $this->processors[] = $processor;
        }

        return $this;
    }

    public function removeProcessor(Processor $processor): self
    {
        $this->processors->removeElement($processor);

        return $this;
    }

    public function getProcessorNote(): ?string
    {
        return $this->processor_note;
    }

    public function setProcessorNote(?string $processor_note): self
    {
        $this->processor_note = $processor_note;

        return $this;
    }

    public function getMemSlots(): ?int
    {
        return $this->mem_slots;
    }

    public function setMemSlots(int $mem_slots): self
    {
        $this->mem_slots = $mem_slots;

        return $this;
    }

    /**
     * @return Collection<int, Memory>
     */
    public function getMemType(): Collection
    {
        return $this->mem_type;
    }

    public function addMemType(Memory $memType): self
    {
        if (!$this->mem_type->contains($memType)) {
            $this->mem_type[] = $memType;
        }

        return $this;
    }

    public function removeMemType(Memory $memType): self
    {
        $this->mem_type->removeElement($memType);

        return $this;
    }

    public function getNbrMaxSata(): ?int
    {
        return $this->nbr_max_sata;
    }

    public function setNbrMaxSata(?int $nbr_max_sata): self
    {
        $this->nbr_max_sata = $nbr_max_sata;

        return $this;
    }

    public function getRaidSupport(): ?RAID
    {
        return $this->raid_support;
    }

    public function setRaidSupport(?RAID $raid_support): self
    {
        $this->raid_support = $raid_support;

        return $this;
    }

    public function getStataSpeed(): ?string
    {
        return $this->stata_speed;
    }

    public function setStataSpeed(?string $stata_speed): self
    {
        $this->stata_speed = $stata_speed;

        return $this;
    }

    public function getLan(): ?string
    {
        return $this->lan;
    }

    public function setLan(?string $lan): self
    {
        $this->lan = $lan;

        return $this;
    }

    public function getUsb(): ?string
    {
        return $this->usb;
    }

    public function setUsb(?string $usb): self
    {
        $this->usb = $usb;

        return $this;
    }

    public function getVideoOutput(): ?string
    {
        return $this->video_output;
    }

    public function setVideoOutput(?string $video_output): self
    {
        $this->video_output = $video_output;

        return $this;
    }

    public function getDom(): ?string
    {
        return $this->dom;
    }

    public function setDom(?string $dom): self
    {
        $this->dom = $dom;

        return $this;
    }

    public function getTpm(): ?string
    {
        return $this->tpm;
    }

    public function setTpm(?string $tpm): self
    {
        $this->tpm = $tpm;

        return $this;
    }

    /**
     * @return Collection<int, PCIE>
     */
    public function getPciESupport(): Collection
    {
        return $this->pci_e_support;
    }

    public function addPciESupport(PCIE $pciESupport): self
    {
        if (!$this->pci_e_support->contains($pciESupport)) {
            $this->pci_e_support[] = $pciESupport;
        }

        return $this;
    }

    public function removePciESupport(PCIE $pciESupport): self
    {
        $this->pci_e_support->removeElement($pciESupport);

        return $this;
    }

    /**
     * @return Collection<int, M2>
     */
    public function getM2(): Collection
    {
        return $this->m2;
    }

    public function addM2(M2 $m2): self
    {
        if (!$this->m2->contains($m2)) {
            $this->m2[] = $m2;
        }

        return $this;
    }

    public function removeM2(M2 $m2): self
    {
        $this->m2->removeElement($m2);

        return $this;
    }

    /**
     * @return Collection<int, BareBone>
     */
    public function getBarbones(): Collection
    {
        return $this->barbones;
    }

    public function addBarbone(BareBone $barbone): self
    {
        if (!$this->barbones->contains($barbone)) {
            $this->barbones[] = $barbone;
            $barbone->addMotherboard($this);
        }

        return $this;
    }

    public function removeBarbone(BareBone $barbone): self
    {
        if ($this->barbones->removeElement($barbone)) {
            $barbone->removeMotherboard($this);
        }

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

    public function setDelivery(?\DateTimeInterface $delivery): self
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

    public function setUrl(?string $url): self
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
}
