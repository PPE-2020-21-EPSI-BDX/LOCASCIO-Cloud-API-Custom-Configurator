<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MemoryRepository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: MemoryRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Memory', 'read:Motherboard', 'read:Memory_detail'],
                'enable_max_depth' => true
            ]
        ]
    ]
)]
class Memory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Memory'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read:Memory'])]
    private string $brand;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Memory'])]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory_detail'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $capacity;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory_detail'])]
    private ?string $cas;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Memory_detail'])]
    private ?int $number;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $type;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $freq;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['read:Memory'])]
    private bool $ecc;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Memory_detail'])]
    private ?string $application;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:Memory'])]
    private Decimal $price;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'mem_type')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Motherboard $motherboards;

    #[Pure] public function __construct()
    {
        $this->motherboards = new Motherboard();
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

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

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(?string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getCas(): ?string
    {
        return $this->cas;
    }

    public function setCas(?string $cas): self
    {
        $this->cas = $cas;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFreq(): ?string
    {
        return $this->freq;
    }

    public function setFreq(?string $freq): self
    {
        $this->freq = $freq;

        return $this;
    }

    public function getEcc(): bool
    {
        return $this->ecc;
    }

    public function setEcc(bool $ecc): self
    {
        $this->ecc = $ecc;

        return $this;
    }

    public function getApplication(): ?string
    {
        return $this->application;
    }

    public function setApplication(?string $application): self
    {
        $this->application = $application;

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

    public function getPrice(): ?decimal
    {
        return $this->price;
    }

    public function setPrice(?decimal $price): self
    {
        $this->price = $price;

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
            $motherboard->addMemType($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeMemType($this);
        }

        return $this;
    }
}
