<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MotherboardRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MotherboardRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Motherboard', 'read:FormFactor', 'read:Motherboard_detail', 'read:Processor', 'read:Memory', 'read:Connector'],
                'enable_max_depth' => true
            ]
        ],
        'patch' => []
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
#[ApiFilter(SearchFilter::class, properties: ['provider_reference' => 'exact'])]
class Motherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Motherboard'])]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $processor_note;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Motherboard_detail'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $url;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?float $price;

    #[ORM\ManyToOne(targetEntity: FormFactor::class)]
    private ?FormFactor $form_factor;

    #[ORM\Column(type: 'integer')]
    private int $tpm;

    #[ORM\ManyToMany(targetEntity: Connector::class)]
    #[ORM\JoinTable("motherboard_interface")]
    #[Groups(['read:Connector'])]
    private ArrayCollection $output;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?int $availability;

    #[ORM\ManyToMany(targetEntity: Memory::class)]
    private $memories;

    #[ORM\ManyToMany(targetEntity: Processor::class)]
    private $processors;

    #[Pure] public function __construct()
    {
        $this->output = new ArrayCollection();
        $this->memories = new ArrayCollection();
        $this->processors = new ArrayCollection();
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

    public function getProcessorNote(): ?string
    {
        return $this->processor_note;
    }

    public function setProcessorNote(?string $processor_note): self
    {
        $this->processor_note = $processor_note;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
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

    public function getFormFactor(): ?FormFactor
    {
        return $this->form_factor;
    }

    public function setFormFactor(?FormFactor $form_factor): self
    {
        $this->form_factor = $form_factor;

        return $this;
    }

    public function getTpm(): ?int
    {
        return $this->tpm;
    }

    public function setTpm(int $tpm): self
    {
        $this->tpm = $tpm;

        return $this;
    }

    /**
     * @return Collection<int, Connector>
     */
    public function getOutput(): Collection
    {
        return $this->output;
    }

    public function addOutput(Connector $output): self
    {
        if (!$this->output->contains($output)) {
            $this->output[] = $output;
        }

        return $this;
    }

    public function removeOutput(Connector $output): self
    {
        $this->output->removeElement($output);

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

    /**
     * @return Collection<int, Memory>
     */
    public function getMemories(): Collection
    {
        return $this->memories;
    }

    public function addMemory(Memory $memory): self
    {
        if (!$this->memories->contains($memory)) {
            $this->memories[] = $memory;
        }

        return $this;
    }

    public function removeMemory(Memory $memory): self
    {
        $this->memories->removeElement($memory);

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
}
