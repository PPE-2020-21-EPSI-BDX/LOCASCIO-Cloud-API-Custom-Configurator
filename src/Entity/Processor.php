<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProcessorRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: ProcessorRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Processor', 'read:Processor_detail', 'read:Motherboard'],
                'enable_max_depth' => true
            ]
        ],
        'patch' => []
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
#[ApiFilter(SearchFilter::class, properties: ['provider_reference' => 'exact'])]
class Processor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Processor'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(['read:Processor'])]
    private ?string $brand;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Processor'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?DateTime $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $socket;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?int $upi;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Processor'])]
    private ?int $cores;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?int $threads;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['read:Processor'])]
    private ?string $tdp;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor'])]
    private ?string $baseFreq;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $boostFreq;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor'])]
    private ?string $cache;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $max_mem_capacity;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $max_mem_speed;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $mem_type;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?string $application;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'processors')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Collection $motherboards;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:Processor'])]
    private ?float $price;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?bool $ecc;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(['read:Processor_detail'])]
    private ?bool $graficsProcessor;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Processor'])]
    private ?int $availability;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
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

    public function getProviderReference(): ?string
    {
        return $this->provider_reference;
    }

    public function setProviderReference(?string $provider_reference): self
    {
        $this->provider_reference = $provider_reference;

        return $this;
    }

    public function getSocket(): ?string
    {
        return $this->socket;
    }

    public function setSocket(?string $socket): self
    {
        $this->socket = $socket;

        return $this;
    }

    public function getUpi(): ?int
    {
        return $this->upi;
    }

    public function setUpi(?int $upi): self
    {
        $this->upi = $upi;

        return $this;
    }

    public function getCores(): ?int
    {
        return $this->cores;
    }

    public function setCores(?int $cores): self
    {
        $this->cores = $cores;

        return $this;
    }

    public function getThreads(): ?int
    {
        return $this->threads;
    }

    public function setThreads(?int $threads): self
    {
        $this->threads = $threads;

        return $this;
    }

    public function getTdp(): ?string
    {
        return $this->tdp;
    }

    public function setTdp(?string $tdp): self
    {
        $this->tdp = $tdp;

        return $this;
    }

    public function getBaseFreq(): ?string
    {
        return $this->baseFreq;
    }

    public function setBaseFreq(?string $baseFreq): self
    {
        $this->baseFreq = $baseFreq;

        return $this;
    }

    public function getBoostFreq(): ?string
    {
        return $this->boostFreq;
    }

    public function setBoostFreq(?string $boostFreq): self
    {
        $this->boostFreq = $boostFreq;

        return $this;
    }

    public function getCache(): ?string
    {
        return $this->cache;
    }

    public function setCache(?string $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    public function getMaxMemCapacity(): ?string
    {
        return $this->max_mem_capacity;
    }

    public function setMaxMemCapacity(?string $max_mem_capacity): self
    {
        $this->max_mem_capacity = $max_mem_capacity;

        return $this;
    }

    public function getMaxMemSpeed(): ?string
    {
        return $this->max_mem_speed;
    }

    public function setMaxMemSpeed(?string $max_mem_speed): self
    {
        $this->max_mem_speed = $max_mem_speed;

        return $this;
    }

    public function getMemType(): ?string
    {
        return $this->mem_type;
    }

    public function setMemType(?string $mem_type): self
    {
        $this->mem_type = $mem_type;

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
            $motherboard->addProcessor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeProcessor($this);
        }

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

    public function getEcc(): ?bool
    {
        return $this->ecc;
    }

    public function setEcc(?bool $ecc): self
    {
        $this->ecc = $ecc;

        return $this;
    }

    public function getGraficsProcessor(): ?bool
    {
        return $this->graficsProcessor;
    }

    public function setGraficsProcessor(?bool $graficsProcessor): self
    {
        $this->graficsProcessor = $graficsProcessor;

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
