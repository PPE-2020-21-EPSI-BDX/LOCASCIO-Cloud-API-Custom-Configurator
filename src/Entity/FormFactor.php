<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\FormFactorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormFactorRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:FormFactor', 'read:Motherboard'],
                'enable_max_depth' => true
            ]
        ],
        'patch' => []
    ],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class FormFactor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:FormFactor'])]
    private ?string $name;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}