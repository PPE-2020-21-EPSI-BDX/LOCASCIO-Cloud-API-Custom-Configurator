<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiskRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: DiskRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Disk', 'read:Connector'],
                'enable_max_depth' => true
            ]
        ]
    ]
)]
class Disk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Disk'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(['read:Disk'])]
    private string $capacity;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $read_speed;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $write_speed;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $shuffle_playback;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $random_writing;

    #[ORM\ManyToOne(targetEntity: Connector::class, inversedBy: 'disks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Connector'])]
    #[MaxDepth(1)]
    private Connector $interface;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $application;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['read:Disk'])]
    private ?string $hdd_rotation_speed;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Disk'])]
    private ?int $availability;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['read:Disk'])]
    private ?DateTimeInterface $delivery;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read:Disk'])]
    private string $provider_reference;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Disk'])]
    private string $url;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:Disk'])]
    private float $price;

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

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getReadSpeed(): ?string
    {
        return $this->read_speed;
    }

    public function setReadSpeed(?string $read_speed): self
    {
        $this->read_speed = $read_speed;

        return $this;
    }

    public function getWriteSpeed(): ?string
    {
        return $this->write_speed;
    }

    public function setWriteSpeed(?string $write_speed): self
    {
        $this->write_speed = $write_speed;

        return $this;
    }

    public function getShufflePlayback(): ?string
    {
        return $this->shuffle_playback;
    }

    public function setShufflePlayback(?string $shuffle_playback): self
    {
        $this->shuffle_playback = $shuffle_playback;

        return $this;
    }

    public function getRandomWriting(): ?string
    {
        return $this->random_writing;
    }

    public function setRandomWriting(?string $random_writing): self
    {
        $this->random_writing = $random_writing;

        return $this;
    }

    public function getInterface(): ?Connector
    {
        return $this->interface;
    }

    public function setInterface(?Connector $interface): self
    {
        $this->interface = $interface;

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

    public function getHddRotationSpeed(): ?string
    {
        return $this->hdd_rotation_speed;
    }

    public function setHddRotationSpeed(?string $hdd_rotation_speed): self
    {
        $this->hdd_rotation_speed = $hdd_rotation_speed;

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

    public function setPrice(float $price): self
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
}
