<?php

namespace App\Entity;

use App\Repository\RackStorageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RackStorageRepository::class)]
class RackStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Rack::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Rack $rack;

    #[ORM\ManyToOne(targetEntity: FormFactor::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Formfactor $disk_form_factor;

    #[ORM\ManyToOne(targetEntity: Connector::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Connector $storage_connector;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiskFormFactor(): ?FormFactor
    {
        return $this->disk_form_factor;
    }

    public function setDiskFormFactor(?FormFactor $disk_form_factor): self
    {
        $this->disk_form_factor = $disk_form_factor;

        return $this;
    }

    public function getStorageConnector(): ?Connector
    {
        return $this->storage_connector;
    }

    public function setStorageConnector(?Connector $storage_connector): self
    {
        $this->storage_connector = $storage_connector;

        return $this;
    }

    public function getRack(): ?Rack
    {
        return $this->rack;
    }

    public function setRack(?Rack $rack): self
    {
        $this->rack = $rack;

        return $this;
    }
}
