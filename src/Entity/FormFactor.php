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
                'groups' => ['read:FormFactor', 'read:Motherboard'],
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

    #[ORM\OneToMany(mappedBy: 'form_factor', targetEntity: M2::class)]
    #[Groups(['read:FormFactor'])]
    #[MaxDepth(1)]
    private Collection $m2s_form_factor;

    #[ORM\OneToMany(mappedBy: 'form_factor', targetEntity: Motherboard::class)]
    #[Groups(['read:Motherboard'])]
    #[MaxDepth(1)]
    private ArrayCollection $motherboards;

    #[Pure] public function __construct()
    {
        $this->m2s_form_factor = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
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
            $motherboard->setFormFactor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            // set the owning side to null (unless already changed)
            if ($motherboard->getFormFactor() === $this) {
                $motherboard->setFormFactor(null);
            }
        }

        return $this;
    }
}
