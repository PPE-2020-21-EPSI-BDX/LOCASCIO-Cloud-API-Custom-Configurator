<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\M2Repository;
use Decimal\Decimal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: M2Repository::class)]
#[ApiResource]
class M2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: FormFactor::class, inversedBy: 'm2s')]
    private Collection $form_factor;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'm2')]
    private Collection $motherboards;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?Decimal $price;

    #[ORM\ManyToOne(targetEntity: FormFactor::class, inversedBy: 'm2s')]
    private $interface;

    #[Pure] public function __construct()
    {
        $this->form_factor = new ArrayCollection();
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

    /**
     * @return Collection<int, FormFactor>
     */
    public function getFormFactor(): Collection
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
