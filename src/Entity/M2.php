<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\M2Repository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: M2Repository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:M2', 'read:FormFactor', 'read:MotherBoard']]
        ]
    ]
)]
class M2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:M2'])]
    private string $name;

    #[ORM\ManyToMany(targetEntity: FormFactor::class, inversedBy: 'm2s')]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private FormFactor $form_factor;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'm2')]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private Motherboard $motherboards;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:M2'])]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:M2'])]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:M2'])]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:M2'])]
    private ?Decimal $price;

    #[ORM\ManyToOne(targetEntity: FormFactor::class, inversedBy: 'm2s')]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private FormFactor $interface;

    #[Pure] public function __construct()
    {
        $this->form_factor = new FormFactor();
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

    /**
     * @return FormFactor
     */
    public function getFormFactor(): FormFactor
    {
        return $this->form_factor;
    }

    public function addFormFactor(FormFactor $formFactor): self
    {
        if (!$this->form_factor->contains($formFactor)) {
            $this->form_factor[] = $formFactor;
        }

        return $this;
    }

    public function removeFormFactor(FormFactor $formFactor): self
    {
        $this->form_factor->removeElement($formFactor);

        return $this;
    }

    /**
     * @return Motherboard
     */
    public function getMotherboards(): Motherboard
    {
        return $this->motherboards;
    }

    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addM2($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeM2($this);
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

    public function getInterface(): ?FormFactor
    {
        return $this->interface;
    }

    public function setInterface(?FormFactor $interface): self
    {
        $this->interface = $interface;

        return $this;
    }
}
