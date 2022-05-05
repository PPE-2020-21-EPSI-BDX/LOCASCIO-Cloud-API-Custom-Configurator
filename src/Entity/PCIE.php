<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PCIERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PCIERepository::class)]
#[ApiResource]
class PCIE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $version;

    #[ORM\Column(type: 'string', length: 4, nullable: true)]
    private ?string $format;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'pci_e_support')]
    private Collection $motherboards;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: M2::class)]
    private Collection $m2s;

    #[ORM\OneToMany(mappedBy: 'pcie', targetEntity: RAID::class)]
    private Collection $raids;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?string $price;

    #[Pure] public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->m2s = new ArrayCollection();
        $this->raids = new ArrayCollection();
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

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

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
            $motherboard->addPciESupport($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removePciESupport($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, M2>
     */
    public function getM2s(): Collection
    {
        return $this->m2s;
    }

    public function addM2(M2 $m2): self
    {
        if (!$this->m2s->contains($m2)) {
            $this->m2s[] = $m2;
            $m2->setInterface($this);
        }

        return $this;
    }

    public function removeM2(M2 $m2): self
    {
        if ($this->m2s->removeElement($m2)) {
            // set the owning side to null (unless already changed)
            if ($m2->getInterface() === $this) {
                $m2->setInterface(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RAID>
     */
    public function getRaids(): Collection
    {
        return $this->raids;
    }

    public function addRaid(RAID $raid): self
    {
        if (!$this->raids->contains($raid)) {
            $this->raids[] = $raid;
            $raid->setPcie($this);
        }

        return $this;
    }

    public function removeRaid(RAID $raid): self
    {
        if ($this->raids->removeElement($raid)) {
            // set the owning side to null (unless already changed)
            if ($raid->getPcie() === $this) {
                $raid->setPcie(null);
            }
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

    public function setProviderReference(string $provider_reference): self
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
