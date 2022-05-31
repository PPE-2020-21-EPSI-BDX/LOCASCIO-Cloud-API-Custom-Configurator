<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ConnectorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ConnectorRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Connector', 'read:RaidCard'],
                'enable_max_depth' => true
            ]
        ],
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class Connector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Connector'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $max_transfer_speed;

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

    public function getMaxTransferSpeed(): ?string
    {
        return $this->max_transfer_speed;
    }

    public function setMaxTransferSpeed(?string $max_transfer_speed): self
    {
        $this->max_transfer_speed = $max_transfer_speed;

        return $this;
    }
}
