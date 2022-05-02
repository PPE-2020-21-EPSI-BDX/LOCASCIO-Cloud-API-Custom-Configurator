<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FirewallRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FirewallRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Firewall', 'read:FormFactor']]
        ]
    ]
)]
class Firewall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Firewall'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Firewall'])]
    private ?string $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?int $nbr_wan_ports;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?int $nbr_lan_ports;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?string $wan_port_throughput;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?string $lan_port_throughput;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?int $weight;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?int $is_for_professional;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $url;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?string $price;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:Firewall'])]
    private ?string $dimensions;

    #[ORM\ManyToOne(targetEntity: FormFactor::class, inversedBy: 'firewalls')]
    #[Groups(['read:FormFactor'])]
    private ?FormFactor $form_factor;

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

    public function getNbrWanPorts(): ?int
    {
        return $this->nbr_wan_ports;
    }

    public function setNbrWanPorts(?int $nbr_wan_ports): self
    {
        $this->nbr_wan_ports = $nbr_wan_ports;

        return $this;
    }

    public function getWanPortThroughput(): ?int
    {
        return $this->wan_port_throughput;
    }

    public function setWanPortThroughput(?int $wan_port_throughput): self
    {
        $this->wan_port_throughput = $wan_port_throughput;

        return $this;
    }

    public function getNbrLanPorts(): ?int
    {
        return $this->nbr_lan_ports;
    }

    public function setNbrLanPorts(?int $nbr_lan_ports): self
    {
        $this->nbr_lan_ports = $nbr_lan_ports;

        return $this;
    }

    public function getLanPortThroughput(): ?int
    {
        return $this->lan_port_throughput;
    }

    public function setLanPortThroughput(?int $lan_port_throughput): self
    {
        $this->lan_port_throughput = $lan_port_throughput;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getIsForProfessional(): ?int
    {
        return $this->is_for_professional;
    }

    public function setIsForProfessional(?int $is_for_professional): self
    {
        $this->is_for_professional = $is_for_professional;

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

    public function getFormFactor(): ?FormFactor
    {
        return $this->form_factor;
    }

    public function setFormFactor(?FormFactor $form_factor): self
    {
        $this->form_factor = $form_factor;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }
}
