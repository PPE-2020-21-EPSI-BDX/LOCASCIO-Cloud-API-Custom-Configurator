<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PowerRepository::class)]
#[ApiResource]
class Power
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $capacity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    public function setCapacity(float $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }
}
