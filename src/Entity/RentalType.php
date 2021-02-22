<?php

namespace App\Entity;

use App\Repository\RentalTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalTypeRepository::class)
 */
class RentalType
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
     * @ORM\OneToMany(targetEntity="Article", mappedBy="rentalType")
     */
    private $rentalType;

    public function __construct()
    {
        $this->rentalType = new ArrayCollection();
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
            $rentalType->setRentalType($this);
        }

        return $this;
    }

    public function removeRentalType(Article $rentalType): self
    {
        if ($this->rentalType->removeElement($rentalType)) {
            // set the owning side to null (unless already changed)
            if ($rentalType->getRentalType() === $this) {
                $rentalType->setRentalType(null);
            }
        }

        return $this;
    }
}
