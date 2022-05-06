<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormFactorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: FormFactorRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:FormFactor', 'read:MotherBoard'],
                'enable_max_depth' => true
            ]
        ],
    ],
)]
class FormFactor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:FormFactor'])]
    private ?string $name;

    #[ORM\OneToMany(mappedBy: 'form_factor', targetEntity: Firewall::class)]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $firewalls;

    #[ORM\OneToMany(mappedBy: 'for_factor', targetEntity: Motherboard::class)]
    #[Groups(['read:MotherBoard'])]
    #[MaxDepth(1)]
    private Collection $motherboards;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: M2::class)]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $m2s;

    #[Pure] public function __construct()
    {
        $this->firewalls = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->m2s = new ArrayCollection();
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
            $motherboard->setForFactor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            // set the owning side to null (unless already changed)
            if ($motherboard->getForFactor() === $this) {
                $motherboard->setForFactor(null);
            }
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
            $m2->addFormFactor($this);
        }

        return $this;
    }

    public function removeM2(M2 $m2): self
    {
        if ($this->m2s->removeElement($m2)) {
            $m2->removeFormFactor($this);
        }

        return $this;
    }
}
