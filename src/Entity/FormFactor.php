<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormFactorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormFactorRepository::class)]
#[ApiResource]
class FormFactor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'form_factor', targetEntity: Firewall::class)]
    private $firewalls;

    public function __construct()
    {
        $this->firewalls = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Firewall>
     */
    public function getFirewalls(): Collection
    {
        return $this->firewalls;
    }

    public function addFirewall(Firewall $firewall): self
    {
        if (!$this->firewalls->contains($firewall)) {
            $this->firewalls[] = $firewall;
            $firewall->setFormFactor($this);
        }

        return $this;
    }

    public function removeFirewall(Firewall $firewall): self
    {
        if ($this->firewalls->removeElement($firewall)) {
            // set the owning side to null (unless already changed)
            if ($firewall->getFormFactor() === $this) {
                $firewall->setFormFactor(null);
            }
        }

        return $this;
    }
}
