<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="currency")
     */
    private $rentalType;

    /**
     * @ORM\OneToMany(targetEntity="OperationList", mappedBy="currency")
     */
    private $operationList;

    /**
     * @ORM\OneToMany(targetEntity="OptionList", mappedBy="currency")
     */
    private $optionList;

    public function __construct()
    {
        $this->rentalType = new ArrayCollection();
        $this->operationList = new ArrayCollection();
        $this->optionList = new ArrayCollection();
    }

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

    /**
     * @return Collection|Article[]
     */
    public function getRentalType(): Collection
    {
        return $this->rentalType;
    }

    public function addRentalType(Article $rentalType): self
    {
        if (!$this->rentalType->contains($rentalType)) {
            $this->rentalType[] = $rentalType;
            $rentalType->setCurrency($this);
        }

        return $this;
    }

    public function removeRentalType(Article $rentalType): self
    {
        if ($this->rentalType->removeElement($rentalType)) {
            // set the owning side to null (unless already changed)
            if ($rentalType->getCurrency() === $this) {
                $rentalType->setCurrency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OperationList[]
     */
    public function getOperationList(): Collection
    {
        return $this->operationList;
    }

    public function addOperationList(OperationList $operationList): self
    {
        if (!$this->operationList->contains($operationList)) {
            $this->operationList[] = $operationList;
            $operationList->setCurrency($this);
        }

        return $this;
    }

    public function removeOperationList(OperationList $operationList): self
    {
        if ($this->operationList->removeElement($operationList)) {
            // set the owning side to null (unless already changed)
            if ($operationList->getCurrency() === $this) {
                $operationList->setCurrency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OptionList[]
     */
    public function getOptionList(): Collection
    {
        return $this->optionList;
    }

    public function addOptionList(OptionList $optionList): self
    {
        if (!$this->optionList->contains($optionList)) {
            $this->optionList[] = $optionList;
            $optionList->setCurrency($this);
        }

        return $this;
    }

    public function removeOptionList(OptionList $optionList): self
    {
        if ($this->optionList->removeElement($optionList)) {
            // set the owning side to null (unless already changed)
            if ($optionList->getCurrency() === $this) {
                $optionList->setCurrency(null);
            }
        }

        return $this;
    }
}
