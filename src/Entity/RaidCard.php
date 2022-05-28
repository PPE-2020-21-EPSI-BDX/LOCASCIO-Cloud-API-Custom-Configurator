<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RaidCardRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: RaidCardRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:RaidCard', 'read:Connector', 'read:Level'],
                'enable_max_depth' => true
            ]
        ],
        // 'patch' => []
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
class RaidCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:RaidCard'])]
    private string $name;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:RaidCard'])]
    private int $max_nbr_disk;

    #[ORM\ManyToOne(targetEntity: Connector::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Connector'])]
    #[MaxDepth(1)]
    private Connector $input_to_motherboard;

    #[ORM\ManyToMany(targetEntity: Connector::class, inversedBy: 'raidCards')]
    #[ORM\JoinTable("raid_card_interface")]
    #[ORM\JoinColumn("raid_card_id", "id")]
    #[Groups(['read:Connector'])]
    #[MaxDepth(1)]
    private ArrayCollection $outputs_to_disks;

    #[ORM\ManyToMany(targetEntity: Level::class, inversedBy: 'raidCards')]
    #[Groups(['read:Level'])]
    #[MaxDepth(1)]
    private ArrayCollection $levels;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:RaidCard'])]
    private ?int $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:RaidCard'])]
    private ?DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read:RaidCard'])]
    private string $provider_reference;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:RaidCard'])]
    private float $price;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;


    public function __construct()
    {
        $this->outputs_to_disks = new ArrayCollection();
        $this->levels = new ArrayCollection();
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

    public function getMaxNbrDisk(): ?int
    {
        return $this->max_nbr_disk;
    }

    public function setMaxNbrDisk(int $max_nbr_disk): self
    {
        $this->max_nbr_disk = $max_nbr_disk;

        return $this;
    }

    public function getInputToMotherboard(): ?Connector
    {
        return $this->input_to_motherboard;
    }

    public function setInputToMotherboard(?Connector $input_to_motherboard): self
    {
        $this->input_to_motherboard = $input_to_motherboard;

        return $this;
    }

    /**
     * @return Collection<int, Connector>
     */
    public function getOutputsToDisks(): Collection
    {
        return $this->outputs_to_disks;
    }

    public function addOutputsToDisk(Connector $outputsToDisk): self
    {
        if (!$this->outputs_to_disks->contains($outputsToDisk)) {
            $this->outputs_to_disks[] = $outputsToDisk;
        }

        return $this;
    }

    public function removeOutputsToDisk(Connector $outputsToDisk): self
    {
        $this->outputs_to_disks->removeElement($outputsToDisk);

        return $this;
    }

    /**
     * @return Collection<int, Level>
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    public function addLevel(Level $level): self
    {
        if (!$this->levels->contains($level)) {
            $this->levels[] = $level;
        }

        return $this;
    }

    public function removeLevel(Level $level): self
    {
        $this->levels->removeElement($level);

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

    public function setProviderReference(string $provider_reference): self
    {
        $this->provider_reference = $provider_reference;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
}
