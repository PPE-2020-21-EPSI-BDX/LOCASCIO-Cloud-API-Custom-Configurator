<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MotherboardRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
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

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Motherboard'])]
    private ?int $availability;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $tpm;

    #[ORM\ManyToOne(targetEntity: FormFactor::class)]
    private $form_factor;

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

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(?int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getTpm(): ?int
    {
        return $this->tpm;
    }

    public function setTpm(?int $tpm): self
    {
        $this->tpm = $tpm;

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
}
