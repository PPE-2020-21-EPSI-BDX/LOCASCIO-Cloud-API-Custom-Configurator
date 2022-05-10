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
                'groups' => ['read:FormFactor'],
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
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $motherboards;

    #[ORM\OneToMany(mappedBy: 'form_factor', targetEntity: M2::class)]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $m2s_form_factor;

    #[Pure] public function __construct()
    {
        $this->firewalls = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->m2s_form_factor = new ArrayCollection();
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
    public function getM2sFormFactor(): Collection
    {
        return $this->m2s_form_factor;
    }

    public function addM2sFormFactor(M2 $m2sFormFactor): self
    {
        if (!$this->m2s_form_factor->contains($m2sFormFactor)) {
            $this->m2s_form_factor[] = $m2sFormFactor;
            $m2sFormFactor->setFormFactor($this);
        }

        return $this;
    }

    public function removeM2sFormFactor(M2 $m2sFormFactor): self
    {
        if ($this->m2s_form_factor->removeElement($m2sFormFactor)) {
            // set the owning side to null (unless already changed)
            if ($m2sFormFactor->getFormFactor() === $this) {
                $m2sFormFactor->setFormFactor(null);
            }
        }

        return $this;
    }
}
