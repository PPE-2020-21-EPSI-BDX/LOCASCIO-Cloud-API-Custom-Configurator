<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BareboneRepository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: BareboneRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Barebone', 'read:Motherboard'],
                'enable_max_depth' => true
            ]
        ]
    ]
)]
class Barebone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Barebone'])]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, inversedBy: 'barbones')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Collection $motherboard;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Barebone'])]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Barebone'])]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Barebone'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:Barebone'])]
    private ?Decimal $price;

    #[Pure] public function __construct()
    {
        $this->motherboard = new ArrayCollection();
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

    /**
     * @return Collection<int, Motherboard>
     */
    public function getMotherboard(): Collection
    {
        return $this->motherboard;
    }

    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboard->contains($motherboard)) {
            $this->motherboard[] = $motherboard;
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        $this->motherboard->removeElement($motherboard);

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
}
