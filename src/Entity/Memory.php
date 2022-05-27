<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MemoryRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: MemoryRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Memory', 'read:Motherboard', 'read:Memory_detail'],
                'enable_max_depth' => true
            ]
        ],
        'patch' => []
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['provider_reference' => 'exact'])]
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

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Memory'])]
    private ?DateTimeInterface $delivery;

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

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:Memory'])]
    private ?float $price;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $slot_type;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Memory'])]
    private ?string $provider_reference;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, inversedBy: 'memories')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private $motherboards;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Memory'])]
    private ?int $availability;

    public function __construct()
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDelivery(): ?DateTimeInterface
    {
        return $this->delivery;
    }

    public function setDelivery(?DateTimeInterface $delivery): self
    {
        $this->delivery = $delivery;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlotType(): ?string
    {
        return $this->slot_type;
    }

    public function setSlotType(?string $slot_type): self
    {
        $this->slot_type = $slot_type;

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
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        $this->motherboards->removeElement($motherboard);

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(?int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }
}
